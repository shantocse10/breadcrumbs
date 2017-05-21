# Breadcrumbs - Laravel
Build breadcrumbs easily with this package
## Installation
```sh
$ composer require binjar/breadcrumbs
```
Add the service provider and facade in `config/app.php`
```php
'providers' => [
    Binjar\Breadcrumbs\ServiceProvider::class
];
```
```php
'aliases' => [
    'Breadcrumbs' => Binjar\Breadcrumbs\Facade::class
];
```
## Usage
Create a file called `routes/breadcrumbs.php` that looks like this:

```php
<?php
	Breadcrumbs::push([
			'title' => 'Home',
			'route' => 'welcome',
			'icon' => 'glyphicon glyphicon-comment',
		]);

	Breadcrumbs::push([
			'title' => '@category',
			'route' => 'category',
			'parent' => 'welcome',
			'parameters' => ['category'],
			'icon' => 'glyphicon glyphicon-hdd',
		]);

	Breadcrumbs::push([
			'title' => '@item',
			'route' => 'item_details',
			'parameters' => ['category', 'item'],
			'parent' => 'category_items',
		]);

?>
```
Finally, call Breadcrumbs::render() in the view template for each page, passing it the name of route and any additional parameters
```php
$parameters = [
        'item' => [
                'title' => 'Item Title',
                'value' => '1',
            ],
        'category' => [
                'title' => 'Books',
                'value' => '2',
            ],
    ];
    
    {!! Breadcrumbs::render('route_name', $parameters) !!}
```
