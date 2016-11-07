@extends('sb2.admsb2')

@section('additional_style')
@endsection

@section('additional_js')    
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h3 class="page-header">Master Jenis Barang</h3>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Form Jenis Barang                            
                        </div>
                        @if(!isset($var->id_barang))
                            {!! Form::model($var, ['url' => route('jenisbarang.save'),'class' => 'form-horizontal']) !!}
                        @else
                            {!! Form::model($var,['method' => 'PATCH', 'route' => ['jenisbarang.change',$var->id_barang],'class' => 'form-horizontal']) !!}
                        @endif
                        <div class="panel-body">
                            <div class="form-group{{ $errors->has('kode')?' has-error':'' }}">
                                <label for="kode" class="col-sm-2 control-label">Kode Barang</label>
                                <div class="col-xs-4">
                                    @if(!isset($var->id_barang))
                                        {!! Form::text('kode',null,['class' => 'form-control', 'id' => 'kode']) !!}
                                    @else
                                        {!! Form::text('kode',null,['class' => 'form-control', 'id' => 'kode', 'readonly'=>'readonly']) !!}
                                    @endif
                                    {!! $errors->first('kode','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_barang')?' has-error':'' }}">
                                <label for="nama_barang" class="col-sm-2 control-label">Nama Barang</label>
                                <div class="col-xs-4">
                                    {!! Form::text('nama_barang',null,['class' => 'form-control', 'id' => 'nama_barang']) !!}
                                    {!! $errors->first('nama_barang','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>Simpan</button>
                            <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>Reset</button>
                            {!! Form::close() !!}
                            <a href="{{route('jenisbarang')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>Kembali</a>
                        </div>
                        
                    </div>                     
                </div>
            </div>
        </div>
@endsection