@extends('frontend.master')

@section('content')

<section class="checkout-section">
            <div class="container">
                <form action="{{url('/confirm-order')}}" method="post" class="form-group billing-address-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout-wrapper">
                                <div class="billing-address-wrapper">
                                    <h4 class="title">Billing / Shipping Details</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="name" class="form-control" placeholder="Enter Full Name"/>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="phone" class="form-control" placeholder="Phone *" required/>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea rows="4" name="address" class="form-control" id="address"
                                                placeholder="Enter Full Address"></textarea>
                                        </div>

                                         @php
								            $totalPrice = 0
							             @endphp
                                         @foreach ($cartProducts as $cart )
                                          @php
							                 $totalPrice = $totalPrice + $cart->qty*$cart->price;
                                          @endphp

                                         @endforeach

                                        <div class="col-md-12 mt-3">
                                            @if ($totalPrice >= 25000)
                                            <div style="background: lightgrey;padding: 10px;margin-bottom: 10px;">
                                                <input type="radio" id="inside_dhaka" name="charge" checked value="00" onclick="" />
                                                <label for="inside_dhaka"
                                                    style="font-size: 18px;font-weight: 600;color: #000;">Free Delivery (00
                                                    Tk.)</label>
                                            </div>
                                               
                                            @else
                                             <div style="background: lightgrey;padding: 10px;margin-bottom: 10px;">
                                                <input type="radio" id="inside_dhaka" name="charge" checked value="80" onclick="insideDhakaCharge()" />
                                                <label for="inside_dhaka"
                                                    style="font-size: 18px;font-weight: 600;color: #000;">Inside Dhaka (80
                                                    Tk.)</label>
                                            </div>
                                            <div style="background: lightgrey;padding: 10px;">
                                                <input type="radio" id="outside_dhaka" name="charge" value="150" onclick="outsideDhakaCharge()" />
                                                <label for="outside_dhaka"
                                                    style="font-size: 18px;font-weight: 600;color: #000;">Outside Dhaka (150
                                                    Tk.)</label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout-items-wrapper">
                                @php
								 $totalPrice = 0
							   @endphp
                                @foreach ($cartProducts as $cart)

                                @php
							       $totalPrice = $totalPrice + $cart->qty*$cart->price;
                                @endphp

                                <div class="checkout-item-outer">
                                    <div class="checkout-item-left">
                                        <div class="checkout-item-image">
                                            <img src="{{ asset('backend/images/products/'.$cart->product->image) }}" alt="Image"/>
                                        </div>
                                        <div class="checkout-item-info">
                                            <h6 class="checkout-item-name">
                                                {{$cart->product->name}}
                                            </h6>
                                            <p class="checkout-item-price">
                                                {{$cart->price}} Tk.
                                            </p>
                                            <span class="checkout-item-count">
                                                {{$cart->qty}}
                                            </span>
                                            <br />
                                            @if ($cart->size != null)
                                               <span class="checkout-item-count">
                                                Size: {{$cart->size}}                                                
                                            </span> 
                                                
                                            @endif
                                               
                                            @if ($cart->color != null)
                                            <span class="checkout-item-count">
                                                Color: {{$cart->color}}
                                            </span>
                                                
                                            @endif
                                            {{-- <div class="checkout-product-incre-decre">
                                                <button type="button" title="Decrement" class="qty-decrement-btn">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" readonly name="" placeholder="Qty" min="1" style="height: 35px;" value="1">
                                                <button type="button" title="Increment" class="qty-increment-btn">
                                                    <i class="fas fa-plus"></i>
                                                </button>                                                
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="checkout-item-right">
                                        <a href="{{url('/add-to-cart/delete/'.$cart->id)}}" class="delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                                    
                                @endforeach



                                <div class="sub-total-wrap">
                                    <div class="sub-total-item">
                                         <strong>Sub Total</strong>
                                        <strong id="subTotal">৳ {{ $totalPrice}}</strong>
                                        <input type="hidden" id="inputTotalPrice" name="inputTotalPrice" value="{{$totalPrice}}">
                                    </div>
                                    <div class="sub-total-item">
                                        <strong>Delivery charge</strong>
                                        @if ($totalPrice >= 25000 )
                                            <strong id="deliveryCharge">৳ 00</strong>
                                             @else
                                            <strong id="deliveryCharge">৳ 80</strong>
                                        @endif
                                       
                                    </div>
                                    <div class="sub-total-item grand-total">
                                         <strong>Grand Total</strong>
                                         @if ($totalPrice >= 25000)
                                             <strong id="grandTotal">৳ {{ $totalPrice+0}}</strong>
                                             <input type="hidden" name="inputGrandTotal" id="inputGrandTotal" value="{{$totalPrice+0}}">
                                             @else
                                              <strong id="grandTotal">৳ {{ $totalPrice+80}}</strong>
                                               <input type="hidden" name="inputGrandTotal" id="inputGrandTotal" value="{{$totalPrice+80}}">
                                         @endif
                                    </div>
                                </div>
                                <div class="payment-item-outer">
                                    <h6 class="payment-item-title">
                                        Select Payment Method
                                    </h6>
                                    <div class="payment-items-wrap justify-content-center">
                                        <div class="payment-item-outer">
                                            <input type="radio" name="payment_type" id="cod" value="cod" checked="">
                                            <label class="payment-item-outer-lable" for="cod">
                                                <strong>Cash On Delivery</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-place-btn-outer">
                                    <button type="submit" class="order-place-btn-inner">
                                        Place an Order
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

@endsection

@push('script')
<script>
    function insideDhakaCharge(){
        document.getElementById('deliveryCharge').innerHTML = "৳ "+80;
        let totalPrice = parseFloat(document.getElementById('inputTotalPrice').value);
        let grandTotal = totalPrice+80;
        document.getElementById('grandTotal').innerHTML = "৳ "+grandTotal;
        document.getElementById('inputGrandTotal').value = grandTotal;

    }

     function outsideDhakaCharge(){
        document.getElementById('deliveryCharge').innerHTML = "৳ "+150;
        let totalPrice = parseFloat(document.getElementById('inputTotalPrice').value);
        let grandTotal = totalPrice+150;
        document.getElementById('grandTotal').innerHTML = "৳ "+grandTotal;
        document.getElementById('inputGrandTotal').value = grandTotal;

    }
</script>
    
@endpush