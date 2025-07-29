<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> Dashboard</title>

   @include('backend.includes.style')

  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
    @include('backend.includes.navbar')
      <!--end::Header-->
      <!--begin::Sidebar-->
      @include('backend.includes.sidebar')
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
      @yield('content')
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      @include('backend.includes.footer')
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    
    @include('backend.includes.script')

    @stack('scripts')

  </body>
  <!--end::Body-->
</html>
