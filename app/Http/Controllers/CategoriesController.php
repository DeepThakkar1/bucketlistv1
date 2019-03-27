<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
    	$categories = Category::orderBy('name', 'ASC')->get();
    	return view('categories.index', compact('categories'));
    }


    public function store()
    {

    	$catids = request('categories');

    	session(['categories' => $catids]);

    	$categories = [];

    	foreach ($catids as $key => $cat) {
    		$categories[] = Category::findOrFail($cat);
    	}

    

    	return view('categories.filters', compact('categories'));
    }
}
