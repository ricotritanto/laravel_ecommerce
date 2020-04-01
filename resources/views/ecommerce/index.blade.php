@extends('layouts.ecommerce')

@section('title')
    <title>Dashboard - DW Ecommerce</title>
@endsection

@section('content')
@include('layouts.ecommerce.module.navigation')
@include('layouts.ecommerce.module.banner')




@include('layouts.ecommerce.module.brands')
@endsection