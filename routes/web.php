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

Route::get('/', function () {
    $data = json_encode(array("person"=>[['name'=>"ljq","age"=>20,"sex"=>"man","love"=>"fxq"],['name'=>"fxq","age"=>20,"sex"=>"female"]]));
    return $data;
});
