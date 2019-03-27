<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
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

    public $carts = [];

    public function index()
    {
    	

    	$catIds = session('categories');
    	
    	$categories = [];

    	foreach ($catIds as $key => $cat) {
    		$categories[] = Category::findOrFail($cat);
    	}		

    	$options = [];

    	foreach ($categories as $key => $category) {
    		$options[$category->id] = request('options_' . $category->id);
    	}


    	$all_products = [];

    	foreach ($categories as $key => $category) {
    		$products = Product::where('category_id', $category->id)->whereHas('options',function ($query) use ($options, $category) {
    					
						    $query->where('options.id', $options[$category->id]);
						})->with('options')->get();

            $all_products[] = $products;
    	}

       

        $combinations = $this->combinations($all_products);




        $this->generateCarts($combinations);
        


            // sort alphabetically by name
        usort($this->carts,  array($this, 'compare_rank'));

        // dd($this->carts);

        session(['carts' => $this->carts]);

    	return view('cart.choices', ['carts' => $this->carts]);
    }


    public function choose($index)
    {
        $carts = session('carts');

        $choosen = $carts[$index];

        $order = new Order;

        $order->user_id = auth()->id();

        $order->total = $choosen['total'];

        $order->savings = session('budget') - $order->total;

        $order->save();

        foreach ($choosen['items'] as $key => $product) {
            $order->products()->attach($product);
        }

        return view('cart.choosen', compact( 'order'));
    }



    public function reorder(Order $order)
    {
        $neworder = new Order;

        $neworder->user_id = auth()->id();

        $neworder->total = 0;

        $neworder->savings = 0;

        $neworder->save();

        foreach ($order->products as $key => $product) {
            $neworder->products()->attach($product);
            $neworder->total = $neworder->total + $product->price;
        }

        if($neworder->total < $order->total)
        {
            $savings = $order->savings + ( $order->total - $neworder->total);
        } else {
            $savings = $order->savings - ( $neworder->total - $order->total);
        }

        $neworder->savings = $savings;

        $neworder->save();


        $order = $neworder;

        return view('cart.choosen', compact('order'));
    }











    public function generateCarts($combinations)
    {
        
        $budget = session('budget');
        foreach ($combinations as $key => $combination) {

            $cart = [];

            $cart['items'] = $combination;
            $cart['total'] = 0;
            $cart['total_profit'] = 0;
            $cart['rating'] = 0;

            foreach ($combination as $key => $product) {
                $cart['total'] = $cart['total'] + $product->price;
                $cart['total_profit'] = $cart['total_profit'] + ($product->price - $product->cost_price);
                $cart['rating'] = $cart['rating'] + $product->rating;
            }

            if($cart['total'] <= $budget)
            {
                
                    $cart['total_profit'] = $cart['total_profit'] / count($cart['items']);
                    $cart['rating'] = $cart['rating'] / count($cart['items']);
                    $cart['rank_value'] = $cart['total_profit'] / $cart['rating'] + count($cart['items']);
                    $this->carts[] = $cart;
               
            } else {

                
                $permutations = new \drupol\phpermutations\Generators\Combinations($combination, count($combination)-1);

               //Debugbar::info($permutations->toArray());

                $this->generateCarts($permutations->toArray());
                
                
            } 

        }
    }

     public function compare_rank($a, $b)
    {
        return $a['rank_value'] < $b['rank_value'];
    }

    private function combinations($arrays, $i = 0) {
    if (!isset($arrays[$i])) {
        return array();
    }
    if ($i == count($arrays) - 1) {
        return $arrays[$i];
    }

    // get combinations from subsequent arrays
    $tmp = $this->combinations($arrays, $i + 1);

    $result = array();

    // concat each array from tmp with each element from $arrays[$i]
    foreach ($arrays[$i] as $v) {
        foreach ($tmp as $t) {
            $result[] = is_array($t) ? 
                array_merge(array($v), $t) :
                array($v, $t);
        }
    }


    return $result;
}

}
