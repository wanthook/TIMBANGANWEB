@extends('layouts.app')

@section('additional_style')
@endsection

@section('additional_js')
@endsection

@section('navigator')
<li><a href="{{ url('/home') }}"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
<li>Dashboard</li>            
@endsection

@section('pageheader')
<div class="pageicon"><span class="iconfa-laptop"></span></div>
<div class="pagetitle">
    <h5>All Features Summary</h5>
    <h1>Dashboard</h1>
</div>
@endsection

@section('maincontent')
@endsection