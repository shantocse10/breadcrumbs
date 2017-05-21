<?php 

namespace Binjar\Breadcrumbs;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Exception;

class ServiceProvider extends BaseServiceProvider {
	public function provides()
	{
		return ['breadcrumbs'];
	}

	public function register() {
		$this->app->singleton('breadcrumbs', function ($app) {
			$breadcrumbs = $this->app->make('Binjar\Breadcrumbs\Core');

			$viewPath = __DIR__ . '/../views/';
			$this->loadViewsFrom($viewPath, 'breadcrumbs');
			$breadcrumbs->setView($app['config']['breadcrumbs.view']);
			$breadcrumbs->setIcon($app['config']['breadcrumbs.icon_set']);

			return $breadcrumbs;
		});
	}

	public function boot() {
		$configFile = __DIR__ . '/Config.php';
		$this->mergeConfigFrom($configFile, 'breadcrumbs');
		$this->loadRoute();
	}

	public function loadRoute() {
		if (file_exists($file = $this->app['path.base'].'/routes/breadcrumbs.php'))
			require $file;
		else
			throw new Exception("Breadcrumbs: breadcrumbs.php file not found in route folder.");
	}
}
