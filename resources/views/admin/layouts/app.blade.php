<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layouts.partials.head')
    <style media="screen">
    @media (max-width: 991px) {
      .sidebar {
        z-index: 999;
        margin-left: -175px;
        visibility: inherit;
      }
      .main-wrapper .page-wrapper {
        margin-left: 70px !important;
        width: 80% !important;
      }
    }
    .select2-container{
      width: 100% !important;
    }

    .greenActionButtonTheme{
      background-color: #15D16C;
      color: black;
    }

    .page-item.active .page-link {
      z-index: 3;
      color: #fff;
      background-color: #15d16c !important;
      border-color: #15d16c !important;
    }
    </style>
</head>
<body class="sidebar-dark">
<div class="main-wrapper">
    @include('admin.layouts.partials.sidebar')
    <div class="page-wrapper">
        @include('admin.layouts.partials.navbar')
        @yield('content')
        @include('admin.layouts.partials.footer')
    </div>
</div>
@include('admin.layouts.partials.footer-scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script type="text/javascript">
  if ($("#add_article_details").length) {
    ClassicEditor.create(document.querySelector('#add_article_details'))
    .then( editor => {})
    .catch( error => {});
  }
</script>


<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js')}}"></script>

@include('admin.includes.scripts')
</body>
</html>
