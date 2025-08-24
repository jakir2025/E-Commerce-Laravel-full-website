@extends('backend.master')

@section('content')

  <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Order List</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Order List</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <form action="{{url('/admin/orders/all')}}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="search" id="search" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{url('/admin/orders/all')}}" class="btn btn-danger">Clear</a>
                        </div>
                    </div>
                    </form>
                </div>
                

              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Order List Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Order Date</th>
                          <th>Invoice</th>
                          <th>Product(s)</th>
                          <th>Customer Info</th>
                          <th>Price</th>
                          <th>Delivery Charge</th>
                          <th>Courier</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                @foreach ($orders as $order )
                     <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->invoice_number}}</td>
                        <td>
                           @foreach ($order->orderDetails as $details)
                            <img src="{{asset('backend/images/products/'.$details->product->image)}}" height="100" width="100" alt="">
                             {{$details->product->image}} X {{$details->qty}} <br>
                           @endforeach
                        </td>

                        <td>
                            <p style="color: red">IP: {{$order->ip_address}}</p>
                            Name: {{$order->name}} 
                            <p style="color: green"><b>Phone:{{$order->phone}}</b></p>
                            <strong class="text-primary">Address: {{$order->address}}</strong>
                        </td>

                        <td>{{$order->price}}</td>
                        <td>{{$order->charge}}</td>
                        <td>
                            {{$order->courier_name??"Courier Not Selected"}}
                            <p class="text-success">{{$order->consignment_id}}</p>
                        </td>
                        {{-- <td>
                            <form action="{{url('/admin/order/status/'.$order->id)}}" method="GET" id="statusUpdate{{$order->id}}">
                                @csrf
                                <select name="status" id="" class="form-control" onchange="statusFormSubmission()">
                                    <option value="pending" @if ($order->status == "pending")
                                        selected
                                    @endif>Pending</option>
                                    <option value="confirmed" @if ($order->status == "confirmed")
                                        selected
                                        @endif>Confirm</option>
                                    <option value="delivered" @if ($order->status == "delivered")
                                        selected
                                        @endif>Delivery</option>
                                    <option value="cancelled" @if ($order->status == "cancelled")
                                        selected
                                         @endif>Cancel</option>
                                    <option value="returned" @if ($order->status == "returned")
                                        selected
                                        @endif>Return</option>
                                </select>
                            </form>
                        </td> --}}

                           <td>
                              <form action="{{url('/admin/order/status/'.$order->id)}}" method="GET" id="statusUpdate{{$order->id}}">
                              @csrf
                                <select name="status" class="form-control" onchange="statusFormSubmission({{$order->id}})">
                                    <option value="pending" @if ($order->status == "pending") selected @endif>Pending</option>
                                    <option value="confirmed" @if ($order->status == "confirmed") selected @endif>Confirm</option>
                                    <option value="delivered" @if ($order->status == "delivered") selected @endif>Delivery</option>
                                    <option value="cancelled" @if ($order->status == "cancelled") selected @endif>Cancel</option>
                                    <option value="returned" @if ($order->status == "returned") selected @endif>Return</option>
                                 </select>
                               </form>
                            </td>

                        <td>
                            <a href="{{url('/admin/order/edit/'.$order->id)}}" class="btn btn-sm btn-primary">Details</a>
                            <a href="{{url('/admin/order/delete/'.$order->id)}}" onclick="return confirm('Are you sure you want to delete this category?');" class="btn btn-sm btn-danger">Delete</a>
                          </td>
                       </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->

@endsection

@push('scripts')
{{-- <script>
    public function statusFormSubmission()
    {
        document.getElementById('statusUpdate').submit();
    }
</script> --}}

<script>
    function statusFormSubmission(orderId) {
        document.getElementById('statusUpdate' + orderId).submit();
    }
</script>

@endpush