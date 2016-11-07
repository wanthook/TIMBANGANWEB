@extends('layouts.sb2')

@section('nav_content')
        <ul class="nav navbar-top-links navbar-right">
            Selamat Datang,
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    {{ Auth::user()->name }}<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
<!--                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>-->
                    <li><a href="#" data-toggle="modal" data-target="#modalChangePass"><i class="fa fa-gear fa-fw"></i> Ubah Password</a>
                    </li>                    
                    <li class="divider"></li>
                    <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
        </ul>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">                    
                    <li>
                        <a href="{{ route('home.root') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    @if(isset($menu))
                        {!! $menu !!}
                    @endif                    
                </ul>
            </div>
        </div>

@endsection

@section('body_content')        
        <div id="page-wrapper">

        </div>
@endsection

@section('modal_content')

    <div class="modal fade" id="modalChangePass" tabindex="-1" role="dialog" aria-labelledby="modalChangePassLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Ubah Password</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(['url' => route('changepass'),'class' => 'form-horizontal']) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="old_password" class="col-sm-5 control-label">Password Lama</label>
                            <div class="col-xs-7">
                                {!! Form::text('old_password',null,['class' => 'form-control', 'id' => 'old_password', 'placeholder' => 'Password Lama']) !!}
                                {!! $errors->first('old_password','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="new_password" class="col-sm-5 control-label">Password Baru</label>
                            <div class="col-xs-7">
                                {!! Form::text('new_password',null,['class' => 'form-control', 'id' => 'new_password', 'placeholder' => 'Password Baru']) !!}
                                {!! $errors->first('new_password','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="retype_password" class="col-sm-5 control-label">Ulangi Password Baru</label>
                            <div class="col-xs-7">
                                {!! Form::text('retype_password',null,['class' => 'form-control', 'id' => 'retype_password', 'placeholder' => 'Ulangi Password Baru']) !!}
                                {!! $errors->first('retype_password','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary">Rubah Password</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    </div>
@endsection