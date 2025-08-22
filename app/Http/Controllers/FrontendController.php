<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;


class FrontendController extends Controller
{
    public function index(){
        $categories = Category::orderBy('name', 'asc')->with('subCategories')->get();
        //  dd($categories);
        $hotProducts = Product::where('product_type', 'hot') ->orderBy('id' , 'desc')->paginate(20);
        $newProducts = Product::where('product_type', 'new') ->orderBy('id', 'desc')->paginate(20);
        $regulerProducts = Product::where('product_type', 'regular') ->orderBy('id', 'desc')->paginate(20);
        $discountProducts = Product::where('product_type', 'discount') ->orderBy('id', 'desc')->paginate(20);
        
        return view('frontend.index', compact('hotProducts', 'newProducts', 'regulerProducts', 'discountProducts', 'categories'));
    }
    public function categoryProducts($slug, $id)
    {
        $category = Category::find($id);
        $products = Product::where('cat_id', $id)->get();
        $productsCount = Product::where('cat_id', $id)->count();
        return view('frontend.categoryProducts', compact('products', 'productsCount', 'category'));
    }
    public function subCategoryProducts($slug, $id)
    {
        $subCategory = SubCategory::find($id);
        $products = Product::where('sub_cat_id', $id)->get();
        $productsCount = Product::where('sub_cat_id', $id)->count();
        return view('frontend.subcategory-products', compact('subCategory', 'products', 'productsCount'));
    }

    public function shopProducts(Request $request)
    {
        if(isset($request->cat_id)){
            $products = Product::orderBy('id', 'desc')->where('cat_id', $request->cat_id)->paginate(20);
        }
        elseif(isset($request->sub_cat_id)){
            $products = Product::orderBy('id', 'desc')->where('sub_cat_id', $request->sub_cat_id)->paginate(20);
        }
        else{
           $products = Product::orderBy('id', 'desc')->paginate(20);
        }
        $productsCount = $products->count();
        // $productsCount = Product::orderBy('id', 'desc')->count();
        return view('frontend.shop', compact('productsCount', 'products'));
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
            toastr()->success('Data has been saved successfully!');
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
            toastr()->success('Data has been saved successfully!');
            return redirect()->back();

        }
    }

    public function addToCartDelete($id)
{
    $cart = Cart::find($id);

    if ($cart) {
        $cart->delete();
        return redirect()->back()->with('success', 'Item removed from cart.');
    } else {
        return redirect()->back()->with('error', 'Cart item not found.');
    }
}


    // public function addToCartDelete($id)
    // {
    //     $cart = Cart::find($id);

    //     $cart->delete();
    //     return redirect()->back();
    // }
    

    public function typeProducts($type){
        $products = Product::where('product_type', $type)->get();
        $productsCount = Product::where('product_type', $type)->count();
        return view('frontend.type-products', compact('type', 'products', 'productsCount'));
    }
    public function viewCart(){

        return view('frontend.view-cart');
    }

    public function checkOut(){
        return view('frontend.checkout');
    }

    public function confirmOrder(Request $request)
    {
        $order = new Order();

        $order->ip_address = $request->ip();

        $previousOrder = Order::orderBy('id', 'desc')->first();

        if($previousOrder == null){
            $generateInvoice = "XWZ-01";
            $order->invoice_number = $generateInvoice;

        }
        elseif($previousOrder != null){
            $generateInvoice = "XWZ-".$previousOrder->id+1;
            $order->invoice_number = $generateInvoice;

        }

        // $order->invoice_number = "XWZ-01";
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->charge = $request->charge;
        $order->price = $request->inputGrandTotal;

        $cartProducts = Cart::where('ip_address', $request->ip())->get();

        if($cartProducts->isNotEmpty()){
            $order->save();

            foreach($cartProducts as $cart){
                $orderDetails = new OrderDetails();

                $orderDetails->order_id = $order->id;
                $orderDetails->product_id = $cart->product_id;
                $orderDetails->color = $cart->color;
                $orderDetails->size = $cart->size;
                $orderDetails->qty = $cart->qty;
                $orderDetails->price = $cart->price;

                $orderDetails->save();
                $cart->delete();
                

            }

            return redirect('success-order/'.$generateInvoice);

        }
        else{
            return redirect('/');
        }


    }

    public function successOrder ($invoiceid)
    {
        return view('frontend.thankyou', compact('invoiceid'));
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
