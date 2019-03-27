<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
    	$products = Product::limit(8)->get();
    	return view('welcome', compact('products'));
    }
}
