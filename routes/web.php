<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
		$crawler = Goutte::request('GET', env('APPLIANCES_URL').'/dishwashers?page=2');

    $crawler->filter('.search-results-product')->each(function ($node) {
			$name = $node->filter('h4 > a')->first()->text();
			// $price_string = $node->filter('h3.section-title');
			// $price = (float)explode('€', $price_string->text())[1];
			$price = $node->filter('h3.section-title')->first()->text();
			$description_list[] = $node->filter('ul.result-list-item-desc-list > li')->each(function($node) {
				return $node->text();
			});

			foreach($description_list as $text) {
				foreach($text as $listText) {
					$list[] = $listText;
				}
			}
			// var_dump($description_list->text());
			$product = [
				'name' => $name,
				'price' => $price,
				'description' => $list
			];

			dump($product);
		});
		
    //return view('welcome');
});
