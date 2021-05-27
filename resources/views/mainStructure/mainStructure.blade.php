<!-- Secciones de codigo para pagina principal -->

@section('sideBar')
    @include('mainStructure.sideBar')
@endsection

@section('topBar')
    @include('mainStructure.topBar')
@endsection

@section('footer')
    @include('mainStructure.footer')
@endsection

@section('modals')
    @include('mainStructure.modals')
@endsection

<!-- Fin Secciones -->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'Hershey´s') }}</title>

      <link rel="shortcut icon" type="image/png" href="{{ config('app.url', '') }}/public/favicon.ico">

      <!-- Custom fonts for this template-->
      <link href= "{{ config('app.url', '') }}/css/font-awesone/all.min.css" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

      <!-- Custom styles for this template-->
      <link href="{{ config('app.url', '') }}/css/template/sb-admin-2.min.css" rel="stylesheet">

      <!-- Custom Styles Owner -->
      <link href="{{ config('app.url', '') }}/css/app-hershey.css" rel="stylesheet">

      <!-- Datepicker -->
      <link href="{{ config('app.url', '') }}/css/datepicker.min.css" rel="stylesheet">

      @yield('cssLinks')

  </head>

  <body>

    <div id="wrapper">

        @yield('sideBar')

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @yield('topBar')

            @yield('content')

        </div>
        <!-- End of Main Content -->

        @yield('footer')

      </div>
      <!-- End of Content Wrapper -->

    </div>

    @yield('modals')

  <!-- Bootstrap core JavaScript-->
  <script src="{{ config('app.url', '') }}/js/jquery/jquery.min.js"></script>
  <script src="{{ config('app.url', '') }}/js/bootstrap/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ config('app.url', '') }}/js/jquery/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ config('app.url', '') }}/js/sb-admin-2.min.js"></script>

  <!-- js cookies -->
  <script src="{{ config('app.url', '') }}/js/js.cookie.min.js"></script>

  <!-- Datepicker -->
  <script src="{{ config('app.url', '') }}/js/moment.js"></script>
  <script src="{{ config('app.url', '') }}/js/datepicker.min.js"></script>

  <!-- Custom JS  -->
  <script src="{{ config('app.url', '') }}/js/main.js"></script>

  @yield('jsScripts')

  </body>

</html>
