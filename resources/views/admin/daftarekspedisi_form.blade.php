@extends('sb2.admsb2')

@section('additional_style')
<!-- datetimepicker bootstrap CSS -->
<link href="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
<!--typeahead -->
<link href="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.css')}}" rel="stylesheet">
<!-- Select2 CSS -->
<link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.css')}}" rel="stylesheet">
<link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2-bootstrap.css')}}" rel="stylesheet">
@endsection

@section('additional_js') 
<script src="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.bundle.min.js')}}"></script>
<script>
    $(document).ready(function()
    {
        $.ajaxSetup({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'}
        });
            
        $('#tanggal_pesan').datetimepicker({
            format: "DD-MM-YYYY"
        });
        
        $('#no_pol').typeahead(null, {
            displayKey: 'value',
            source: nopolauto
        });
        
        $('#relasi').typeahead(null, {
            displayKey: 'value',
            source: relasiauto
        });
        
        $('#nama_supir').typeahead(null, {
            displayKey: 'value',
            source: supirauto
        });
        
    });
    
    var relasiauto = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.value)
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "{{route('timbangan.autorelasi')}}",
            prepare: function (query, settings) 
            {
                settings.type = "post";
                settings.dataType = 'json';
                settings.data = {q: query};

                return settings;
             }
        }
    });
    
    var nopolauto = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d)
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "{{route('timbangan.autonopol')}}",
            prepare: function (query, settings) 
            {
                settings.type = "post";
                settings.dataType = 'json';
                settings.data = {q: query};

                return settings;
             }
        }
    });
    
    var supirauto = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d)
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "{{route('timbangan.autosupir')}}",
            prepare: function (query, settings) 
            {
                settings.type = "post";
                settings.dataType = 'json';
                settings.data = {q: query};

                return settings;
             }
        }
    });
    
</script>
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-send-o"></i>
                        </span>&nbsp;&nbsp;<a href="{{route('daftarekspedisi')}}">Pendaftaran Ekspedisi</a>
                        &nbsp;>&nbsp;Form Pendaftaran Ekspedisi                        
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Form Pendaftaran Ekspedisi                            
                        </div>                        
                        @if(!isset($var->id))
                            {!! Form::model($var, ['url' => route('daftarekspedisi.save'),'class' => 'form-horizontal']) !!}
                        @else
                            {!! Form::model($var,['method' => 'PATCH', 'route' => ['daftarekspedisi.change',$var->id],'class' => 'form-horizontal']) !!}
                        @endif
                        <div class="panel-body">                            
                            <div class="form-group{{ $errors->has('tanggal_pesan')?' has-error':'' }}">
                                <label for="tanggal_pesan" class="col-sm-2 control-label">Tanggal Pesan *</label>
                                <div class="col-xs-4">
                                    <div class="input-group date">
                                        {!! Form::text('tanggal_pesan',null,['class' => 'form-control', 'id' => 'tanggal_pesan', 'placeholder' => 'Tanggal Pesan']) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        {!! $errors->first('tanggal_pesan','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('no_pol')?' has-error':'' }}">
                                <label for="no_pol" class="col-sm-2 control-label">Nomor Polisi *</label>
                                <div class="col-xs-6">
                                    {!! Form::text('no_pol',null,['class' => 'form-control typeahead', 'id' => 'no_pol']) !!}                                    
                                    {!! $errors->first('no_pol','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('relasi')?' has-error':'' }}">
                                <label for="relasi" class="col-sm-2 control-label">Relasi *</label>
                                <div class="col-xs-10">
                                    {!! Form::text('relasi',null,['class' => 'form-control typeahead', 'id' => 'relasi', 'placeholder' => 'Relasi']) !!}
                                    {!! $errors->first('relasi','<span class="help-block">:message</span>') !!}
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('nama_supir')?' has-error':'' }}">
                                <label for="nama_supir" class="col-sm-2 control-label">Nama Supir *</label>
                                <div class="col-xs-6">
                                    {!! Form::text('nama_supir',null,['class' => 'form-control', 'id' => 'nama_supir']) !!}                                    
                                    {!! $errors->first('nama_supir','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>Simpan</button>
                            <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>Reset</button>
                            {!! Form::close() !!}
                            <a href="{{route('daftarekspedisi')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>Kembali</a>
                        </div>
                        
                    </div>                     
                </div>
            </div>
        </div>
@endsection