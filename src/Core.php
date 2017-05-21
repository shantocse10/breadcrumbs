<?php
namespace Binjar\Breadcrumbs;
use Exception;

class Core {
	private $items = [];
	private $view;
	private $view_name;
	private $icon_set;

	public function __construct(View $view) {
		$this->view = $view;
	}

	public function push($item) {
		if (!isset($item['title']))
			throw new Exception("Breadcrumbs: No title found.");

		if (!isset($item['route']))
			throw new Exception("Breadcrumbs: No route found.");

		$index = $this->getIndex($item['route']);

		if ($index !== false)
			throw new Exception("Breadcrumbs: Already breadcrumb exists for ".$item['route']);

		$this->items[] = $item;
	}

	public function render($route='', $parameters=[]) {
		$render_items = [];

		if (empty($route))
			throw new Exception("Breadcrumbs: No route found.");
		$current_route = $route;

		do {
			$index = $this->getIndex($current_route);

			if ($index === false)
				throw new Exception("Breadcrumbs: No breadcrumbs set for ".$current_route.".");

		   	$title = $this->items[$index]['title'];

			if ($title[0] == '@') {
				$tmp_name = substr($title, 1);

				if (!isset($parameters[$tmp_name]['title']))
					throw new Exception("Breadcrumbs: No title set for parameter ".$tmp_name.".");

				$title = $parameters[$tmp_name]['title'];
			}

			$route_name = $this->items[$index]['route'];

			if (isset($this->items[$index]['parameters'])){
				$route_parameters = [];

				foreach($this->items[$index]['parameters'] as $parameter){
					if (!isset($parameters[$parameter]['value']))
						throw new Exception("Breadcrumbs: No value set for ".$parameter);
					
					$route_parameters[$parameter] = $parameters[$parameter]['value'];
				}

				try {
					$url = route($route_name, $route_parameters);
				} catch (Exception $e) {
					throw new Exception("Breadcrumbs: No route found named ".$current_route);
				}
				
			} else {
				try {
					$url = route($route_name);
				} catch (Exception $e) {
					throw new Exception("Breadcrumbs: No route found named ".$current_route);
				}
			}

			$icon = null;
			if (isset($this->items[$index]['icon']))
				$icon = $this->items[$index]['icon'];

			$render_items[] = [
				'title' => $title,
				'url' => $url,
				'icon' => $icon,
			];

			if (isset($this->items[$index]['parent']))
				$current_route = $this->items[$index]['parent'];
		}
		while (isset($this->items[$index]['parent']));

		return $this->view->render($this->view_name, $this->icon_set, array_reverse($render_items));	
	}

	public function setView($view) {
		$this->view_name = $view;
	}

	public function setIcon($icon) {
		$this->icon_set = $icon;
	}

	private function getIndex($route) {
		for($i=0; $i<sizeof($this->items); $i++) {
			if ($this->items[$i]['route'] == $route)
				return $i;
		}

		return false;
	}
}