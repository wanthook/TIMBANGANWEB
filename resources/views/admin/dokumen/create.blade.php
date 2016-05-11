@extends('layouts.app')

@section('additional_style')
<link href="{{ asset('/assets/css/select2.css') }}" rel="stylesheet">
<style>
    .table-fixed thead {
  width: 97%;
}
.table-fixed tbody {
  height: 230px;
  overflow-y: auto;
  width: 100%;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}
.table-fixed tbody td, .table-fixed thead > tr> th {
  float: left;
  border-bottom-width: 0;
}
</style>
@endsection

@push('additional_js')
@include('admin.dokumen.script')
@endpush

@section('navigator')
<li><a href="{{ route('home.root') }}"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
<li><a href="{{ route('dokumen.tabel') }}">Dokumen</a> <span class="separator"></span></li>
<li>Form Tambah Dokumen</li>
@endsection

@section('pageheader')
<div class="pageicon"><span class="iconfa-list-alt"></span></div>
<div class="pagetitle">
    <h5>Form Tambah Dokumen</h5>
    <h1>Form</h1>
</div>
@endsection

@section('maincontent')
<div class="widgetbox box-inverse">
    <h4 class="widgettitle">Form Tambah Dokumen</h4>
    <div class="widgetcontent">
        {!! Form::open(array('url' => route('dokumen.tambah'),'class' => 'stdform','files'=> true)) !!}
        @include ('admin.dokumen.form')
        {!! Form::close() !!}
    </div><!--widgetcontent-->
</div>
@endsection