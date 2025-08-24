@extends('backend.master')

@section('content')
 <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Order Details</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Order Details</li>
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
            <div class="row g-4">
              <!--begin::Col-->
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
             <div class="col-md-6">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Customer Details</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="row">
                      <div class="mb-3 col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" value="xwz-1" name="name" id="name" readonly/>
                      </div>

                       <div class="mb-3 col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Customer Name*</label>
                        <input type="text" class="form-control" value="Customer name" name="name" id="name" required/>
                      </div>

                       <div class="mb-3 col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Customer Phone*</label>
                        <input type="text" class="form-control" value="+8801747-909324" name="name" id="name" required/>
                      </div>

                       <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Delivery Charge*</label>
                        <input type="number" class="form-control" value="80" name="name" id="name" required/>
                      </div>

                       <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Customer Address*</label>
                        <textarea class="form-control" name="address" id="address">New Market,Chittagang</textarea>
                      </div>

                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Courier*</label>
                        <select name="courier_name" id="courier_name" class="form-control">
                            <option value="" selected disabled>Select Courier</option>
                            <option value="steadfast">Steadfast</option>
                            <option value="pathao">Pathao</option>
                        </select>
                      </div>
                      </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <!--end::Footer-->
                  <!--end::Form-->
                </div>
                <!--end::Quick Example-->
              </div>
              
              <div class="col-md-6">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Product Details</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Product Name</label>
                        <input
                          type="text"
                          class="form-control"
                          name="name"
                          id="name"
                          required
                        />
                      </div>
                      <div class="input-group mb-3">
                        <input type="file" class="form-control" name="image" id="image" required/>
                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                      </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update Order</button>
                    </div>
                    <!--end::Footer-->
                  <!--end::Form-->
                </div>
                <!--end::Quick Example-->
              </div>
            
            </form>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->

@endsection