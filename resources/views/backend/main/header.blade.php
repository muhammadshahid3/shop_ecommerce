<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{isset($generalsetting->shop_name)?$generalsetting->shop_name:'Shop'}}</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{--Bootstrap Css--}}
  <link href="{{asset('backend_assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('backend_assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

  <link href="{{asset('backend_assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  {{-- Font icons --}}
  <link href="{{asset('backend_assets/font-awesome/css/all.min.css')}}" rel="stylesheet">
  {{-- Template Main CSS File --}}
  <link href="{{asset('backend_assets/css/style.css')}}" rel="stylesheet">
  {{--Swiper Css--}}
  <link rel="stylesheet" href="{{asset('backend_assets/Swiper/swiper.css')}}">
  <link rel="stylesheet" href="{{asset('backend_assets/Swiper/style.css')}}">
 <!-- Template Main CSS File -->
 <!-- <link href="{{asset('backend_assets/css/style.css')}}" rel="stylesheet"> -->
  {{-- Editor Css Link --}}
  <link rel="stylesheet" href="{{asset('backend_assets/summernote/summernote-bs5.css')}}">

  {{-- Data Table Css file end --}}
  <link href="{{asset('backend_assets/YajraBox/css/datatable.css')}}" rel="stylesheet">
  

  {{-- Google Font: Source Sans Pro --}}
  <link rel="stylesheet" href="{{asset('backend_assets/google_fonts/google_font.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('backend_assets/plugins/fontawesome-free/css/all.min.css')}}">
  {{-- icons picker --}}
  <link rel="stylesheet" href="{{asset('backend_assets/iconpicker/fontawesome-browser.css')}}">


</head>
<body>
<style>

</style>