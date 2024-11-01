<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        return view('Shop.index');
    }

    public function checkout(){
        return view('Shop.checkout');
    }
    public function contact(){
        return view('Shop.contact');
    }

    public function detail(){
        return view('Shop.detail');
    }
    public function grid(){
        return view('Shop.grid');
    }
    public function cart(){
        return view('Shop.cart');
    }

    public function blog(){
        return view('Shop.blog');
    }




}
