<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// simple php function that get all products from api
function get_products() {
    $client = new \GuzzleHttp\Client();
    $data = "https://flapotest.blob.core.windows.net/test/ProductData.json";
    $response = $client->request('GET', $data);
    $json_data = json_decode($response->getBody()->getContents());
    return $json_data;
}

// this route send all product to client as json string
// remember it does not return view only json string
Route::get('/products', function() {
    $products = get_products();
    return $products;
});

// this route send all product sorted by price to client as json string
// remember it does not return view only json string
Route::get('/products/sort', function() {
    $products = get_products();
    usort($products, function($p1, $p2){
        return floatval($p1->articles[0]->price) > floatval($p2->articles[0]->price);
    });
    return $products;
});

// this route send all the products which have more price then 2 euros
//  to client as json string
// remember it does not return view only json string
Route::get('/products/filter', function() {
    $products = get_products();
    $new_products = array_filter($products, function($product){
        $price_per_liter = preg_replace('/,/', '.', $product->articles[0]->pricePerUnitText);
        $price_per_liter = preg_replace('/[^\d.]/', '', $price_per_liter);
        return floatval($price_per_liter) > 2;
    });
    return array_values($new_products);
});