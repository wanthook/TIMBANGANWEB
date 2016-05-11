@extends('layouts.apperror')

@section('error_content')
<h4 class="animate0 fadeInUp">Halaman yang anda cari tidak ditemukan.</h4>
<span class="animate1 bounceIn">4</span>
<span class="animate2 bounceIn">0</span>
<span class="animate3 bounceIn">4</span>
<div class="errorbtns animate4 fadeInUp">
    <a onclick="history.back()" class="btn btn-primary btn-large">Kembali ke halaman sebelumnya</a>
</div>
@endsection