<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $categories = Category::orderBy('name', 'asc')->with('subCategories')->get();
        //  dd($categories);
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
    
    public function productDetails($slug){
        $product = Product::where('slug',$slug)->with('color', 'size', 'galleryImage')->first();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('frontend.product-details', compact('product', 'categories'));
    }

    public function addToCartDetails(Request $request, $product_id)
    {
        $cartProduct = Cart::where('product_id', $product_id)->where('ip_address', $request->ip())->first();
        $product = Product::find($product_id); 
        

        if($cartProduct == null){
            $cart = new Cart();

            $cart->ip_address = $request->ip();
            $cart->product_id = $product->id;
            $cart->qty = $request->qty;
            $cart->color = $request->color;
            $cart->size = $request->size;


            if($product->discount_price == null){
                $cart->price = $product->regular_price;
            }
            if($product->discount_price != null){
                $cart->price = $product->discount_price;
            }

            $cart->save();

                if($request->action == "addToCart"){
                    return redirect()->back();
                }
                if($request->action == "buyNow"){
                    return redirect('/checkout');
                }


        }


        elseif($cartProduct != null){
            $cartProduct->qty = $request->qty + $cartProduct->qty;
            $cartProduct->color = $request->color;
            $cartProduct->size = $request->size;
            
             if($product->discount_price == null){
                $cartProduct->price = $product->regular_price;
            }
            if($product->discount_price != null){
                $cartProduct->price = $product->discount_price;
            }

            $cartProduct->save();
            
             if($request->action == "addToCart"){
                    return redirect()->back();
                }
                if($request->action == "buyNow"){
                    return redirect('/checkout');
                }

        }

    }

    public function addToCart (request $request, $product_id){

        $cartProduct = Cart::where('product_id', $product_id)->where('ip_address', $request->ip())->first();
        $product = Product::find($product_id); 
        

         if($cartProduct == null){
            $cart = new Cart();

            $cart->ip_address = $request->ip();
            $cart->product_id = $product->id;
            $cart->qty = 1;


            if($product->discount_price == null){
                $cart->price = $product->regular_price;
            }
            if($product->discount_price != null){
                $cart->price = $product->discount_price;
            }

            $cart->save();
            return redirect()->back();

        }

        elseif($cartProduct != null){
            $cartProduct->qty = 1 + $cartProduct->qty;
            
             if($product->discount_price == null){
                $cartProduct->price = $product->regular_price;
            }
            if($product->discount_price != null){
                $cartProduct->price = $product->discount_price;
            }

            $cartProduct->save();
            return redirect()->back();

        }
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
