@extends('backend.master')

@section('content')
 <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Edit SubCategory</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit SubCategory</li>
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
                  <div class="card-header"><div class="card-title">Edit SubCategory Details</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                  <form action="{{ url('/admin/sub-category/update/' . $subCategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">SubCategory Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $subCategory->name }}" required/>
                      </div>

                       <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Select Category</label>
                            <select class="form-select" name="cat_id" id="cat_id" required>
                            <option selected disabled value="">Select Category</option>
                           @foreach($categories as $category)
                            <option value="{{ $category->id }}"@if($subCategory->cat_id == $category->id) 
                                      selected
                                 @endif>{{ $category->name }}</option>
                           @endforeach
                         </select>
                       </div>
                      </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
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