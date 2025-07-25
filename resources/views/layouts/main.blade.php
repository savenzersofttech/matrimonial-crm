<!DOCTYPE html>
<html lang="en">
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', config('app.name', 'Laravel') | config('app.name', 'Laravel'))</title>
    <meta name="description" content="@yield('meta_description', 'Default description for SEO or page info')">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/img/favicon.ico')}}' />
    
  <link rel="stylesheet" href="{{asset('assets/bundles/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-uL/aABfI9D+GLl..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/css/app.min.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/chocolat.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">

</head>
<body>
  <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            @include('layouts.partials.navbar') 
            @include('layouts.partials.sidebar')

            <div class="main-content">

            

                <section class="section">
                    @yield('content')
                </section>
            </div>
                <footer class="main-footer">
                    <div class="footer-left">
                    <a href="/">CODE</a></a>
                    </div>
                    <div class="footer-right">
                    </div>
                </footer>
        </div>
    </div>
<!-- General JS Scripts -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.chocolat.min.js') }}"></script>
<!-- JS Libraies -->

  <script src="{{asset('assets/bundles/datatables/datatables.min.js')}}"></script>
  <script src="{{asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/bundles/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('assets/js/page/datatables.js')}}"></script> 


<script src="{{ asset('assets/bundles/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('assets/bundles/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
<script src="{{ asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
  <!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
  <!-- Template JS File -->




<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

    @stack('script')

<script>
 $(document).ready(function() {
      // Image preview
      $('#imageInput').change(function(e) {
           const file = e.target.files[0];
           if (file) {
               const reader = new FileReader();
               reader.onload = function(e) {
                   $('#imagePreview').attr('src', e.target.result).show();
               }
               reader.readAsDataURL(file);
           }
           });
      });



</script>

<!-- TOSTER -->
 @if(session('success'))  
    <script>
        iziToast.success({
            title: 'Success!',
            message: '{{ session('success') }}',
            position: 'topRight'
        });
    </script>
 @endif





@if ($errors->any())
            @foreach ($errors->all() as $error)
            <script>
                iziToast.error({
                    title: 'Error!',
                    message: '{{ $error }}',
                    position: 'topRight'
                });
            </script>
            @endforeach
@endif
 @if(session('error'))  
    <script>
        iziToast.error({
            title: 'Error!',
            message: '{{ session('error') }}',
            position: 'topRight'
        });
    </script>
 @endif
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>