@extends('layouts.apperror')

@section('error_content')
<h4 class="animate0 fadeInUp">Be Right Back.</h4>
<span class="animate1 bounceIn">5</span>
<span class="animate2 bounceIn">0</span>
<span class="animate3 bounceIn">3</span>
<div class="errorbtns animate4 fadeInUp">
    <a onclick="history.back()" class="btn btn-primary btn-large">Go to Previous Page</a>
</div>
@endsection