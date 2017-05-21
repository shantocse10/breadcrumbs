<?php 
namespace Binjar\Breadcrumbs;
use Illuminate\Contracts\View\Factory as ViewFactory;

class View {

	protected $factory;

	public function __construct(ViewFactory $factory) {
		$this->factory = $factory;
	}

	public function render($view, $icon_set, $breadcrumbs) {
		if (!$view)
			throw new Exception('Breadcrumbs: No view found.');

		return $this->factory->make($view, compact('breadcrumbs', 'icon_set'))->render();
	}

}
