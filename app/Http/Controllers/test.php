<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class test extends Controller
{
    //
    function getallProduct(){
        // $products = DB::table('food_menu_items')->get();
        
        $products = DB::table('categories')->get();

        return $products;
    }
}