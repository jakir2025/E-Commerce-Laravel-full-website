<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $categories = Category::orderBy('name', 'asc')->get();

        $hotProducts = Product::where('product_type', 'hot') ->orderBy('id' , 'desc')->get();
        $newProducts = Product::where('product_type', 'new') ->orderBy('id', 'desc')->get();
        $regulerProducts = Product::where('product_type', 'reguler') ->orderBy('id', 'desc')->get();
        $discountProducts = Product::where('product_type', 'discount') ->orderBy('id', 'desc')->get();
        
        return view('frontend.index', compact('hotProducts', 'newProducts', 'regulerProducts', 'discountProducts', 'categories'));
    }

    public function shopProducts(){
        return view('frontend.shop');
    }
    public function returnProcess(){
        return view('frontend.return-process');

    }
    public function productDetails(){
        return view('frontend.product-details');
    }
    public function typeProducts($type){
        return view('frontend.type-products', compact('type'));
    }
    public function viewCart(){
        return view('frontend.view-cart');
    }
    public function checkOut(){
        return view('frontend.checkout');
    }

    // Policy 

    public function privacyPolicy(){
        return view('frontend.privacy-policy');
    }
    public function termsCondition(){
        return view('frontend.terms-condition');
    }
    public function refundPolicy(){
        return view('frontend.refund-policy');
    }
    public function paymentPolicy(){
        return view('frontend.payment-policy');
    }
    public function aboutUs(){
        return view('frontend.about-us');
    }
    public function contactUs(){
        return view('frontend.contact-us');
    }
}
