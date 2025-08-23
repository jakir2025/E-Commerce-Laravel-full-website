@extends('backend.master')

@section('content')
 <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Update Settings</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update Settings</li>
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
              <div class="col-md-12">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Input settings Details</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                  <form action="{{ url('/admin/general-settings/update/') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="phone" class="form-label">Phone*</label>
                        <input type="text" class="form-control" value="{{$settings->phone}}" name="phone" id="phone" required/>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input type="text" class="form-control" value="{{$settings->email}}" name="email" id="email" required/>
                      </div>
                      <div class="mb-3">
                        <label for="address" class="form-label">Address*</label>
                        <textarea name="address" class="form-control"  id="address" required >{{$settings->address}}</textarea>
                      </div>
                      <div class="mb-3">
                        <label for="Facebook" class="form-label">Facebook Link(Optional)</label>
                        <input type="text" class="form-control" value="{{$settings->facebook}}" name="Facebook" id="Facebook" />
                      </div>
                      <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter Link(Optional)</label>
                        <input type="text" class="form-control" value="{{$settings->twitter}}" name="twitter" id="twitter" />
                      </div>
                      <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram Link(Optional)</label>
                        <input type="text" class="form-control" value="{{$settings->instagram}}" name="instagram" id="instagram" />
                      </div>
                      <div class="mb-3">
                        <label for="youtube" class="form-label">Youtube Link(Optional)</label>
                        <input type="text" class="form-control" value="{{$settings->youtube}}" name="youtube" id="youtube" />
                      </div>
                      <div class="mb-3">
                        <label for="free_shipping_amount" class="form-label">Free Shipping Amount*</label>
                        <input type="number" class="form-control" value="{{$settings->free_shipping_amount}}" name="free_shipping_amount" id="free_shipping_amount" required/>
                      </div>
                      <div class="input-group mb-3">
                        <input type="file" class="form-control" name="logo" id="logo" />
                        <label class="input-group-text" for="inputGroupFile02">Upload Logo</label>
                        <img src="{{asset('backend/images/Settings/'.$settings->logo)}}" alt="" height="60" width="150">
                      </div>
                       <div class="input-group mb-3">
                        <input type="file" class="form-control" name="hero_image" id="hero_image" />
                        <label class="input-group-text" for="inputGroupFile02">Upload Slider</label>
                        <img src="{{asset('backend/images/Settings/'.$settings->hero_image)}}" alt="" height="400" width="1200">
                      </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <!--end::Footer-->
                  </form>
                  <!--end::Form-->
                </div>
                <!--end::Quick Example-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->

@endsection