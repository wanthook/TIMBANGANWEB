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
            
        $('#tanggal_masuk, #tanggal_keluar').datetimepicker({
            format: "DD-MM-YYYY"
        });
        $('#jam_masuk, #jam_keluar').datetimepicker({
            format: "HH:mm:ss"
        });
        
        $("#id_barang").select2({
            delay: 250,
            minimumInputLength: 0,
            ajax: 
            {
                url: "{{ route('jenisbarang.select2') }}",
                dataType: 'json',
                type: 'post',                
                data: function (term, page) 
                {                
                    return { q : term  }
                },
                results: function(data, page ) 
                {
                    return { results: data }
                }
            },
            initSelection: function(element, callback) 
            {
                var id = jQuery(element).val();

                if(id!="")
                {
                    jQuery.ajax( 
                    {                    
                        url: "{{ route('jenisbarang.select2') }}",
                        dataType: 'json',
                        type: 'post',
                        data: {id: id}
                    }).done(function(data){ callback(data[0]);});
                }
            }
        });
        
        $('#no_pol').typeahead(null, {
            displayKey: 'value',
            source: nopolauto
        });
        
        $('#relasi').typeahead(null, {
            displayKey: 'value',
            source: relasiauto
        });
        
        $('#berat_gross,#berat_tara').on('keyup',function()
        {
            var beratgross = $('#berat_gross').val();
            var berattara  = $('#berat_tara').val();
            
            if(beratgross!="" || berattara!="")
            {
                beratgross = parseInt(beratgross);
                berattara  = parseInt(berattara);
                
                $('#berat_netto').val(beratgross-berattara);
            }
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
    
</script>
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-truck"></i>
                        </span>&nbsp;&nbsp;<a href="{{route('timbangan')}}">Master Timbangan</a>
                        &nbsp;>&nbsp;Form Timbangan                        
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Form Timbangan                            
                        </div>                        
                        @if(!isset($var->timbangan_id))
                            {!! Form::model($var, ['url' => route('timbangan.save'),'class' => 'form-horizontal']) !!}
                        @else
                            {!! Form::model($var,['method' => 'PATCH', 'route' => ['timbangan.change',$var->timbangan_id],'class' => 'form-horizontal']) !!}
                        @endif
                        <div class="panel-body">
                            <div class="form-group{{ $errors->has('kode')?' has-error':'' }}">
                                <label for="kode" class="col-sm-2 control-label">Tiket *</label>
                                <div class="col-xs-4">
                                    @if(!isset($var->timbangan_id))
                                        {!! Form::text('tiket',null,['class' => 'form-control', 'id' => 'tiket']) !!}
                                    @else
                                        {!! Form::text('tiket',null,['class' => 'form-control', 'id' => 'tiket', 'readonly'=>'readonly']) !!}
                                    @endif
                                    {!! $errors->first('tiket','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_masuk')?' has-error':'' }}">
                                <label for="nama_barang" class="col-sm-2 control-label">Tanggal Masuk *</label>
                                <div class="col-xs-4">
                                    <div class="input-group date">
                                        {!! Form::text('tanggal_masuk',null,['class' => 'form-control', 'id' => 'tanggal_masuk', 'placeholder' => 'Tanggal Masuk']) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    {!! $errors->first('tanggal_masuk','<span class="help-block">:message</span>') !!}
                                </div>
                                <label for="nama_barang" class="col-sm-2 control-label">Jam Masuk *</label>
                                <div class="col-xs-4">
                                    <div class="input-group date">
                                        {!! Form::text('jam_masuk',null,['class' => 'form-control', 'id' => 'jam_masuk', 'placeholder' => 'Jam Masuk']) !!}
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                    {!! $errors->first('jam_masuk','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_keluar')?' has-error':'' }}">
                                <label for="nama_barang" class="col-sm-2 control-label">Tanggal keluar *</label>
                                <div class="col-xs-4">
                                    <div class="input-group date">
                                        {!! Form::text('tanggal_keluar',null,['class' => 'form-control', 'id' => 'tanggal_keluar', 'placeholder' => 'Tanggal keluar']) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    {!! $errors->first('tanggal_keluar','<span class="help-block">:message</span>') !!}
                                </div>
                                <label for="nama_barang" class="col-sm-2 control-label">Jam keluar *</label>
                                <div class="col-xs-4">
                                    <div class="input-group date">
                                        {!! Form::text('jam_keluar',null,['class' => 'form-control', 'id' => 'jam_keluar', 'placeholder' => 'Jam keluar']) !!}
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                    {!! $errors->first('jam_keluar','<span class="help-block">:message</span>') !!}
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
                            <div class="form-group{{ $errors->has('id_barang')?' has-error':'' }}">
                                <label for="id_barang" class="col-sm-2 control-label">Nama Barang *</label>
                                <div class="col-xs-6">
                                    {!! Form::hidden('id_barang',null,['class' => 'form-control', 'id' => 'id_barang']) !!}                                    
                                    {!! $errors->first('id_barang','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_supir')?' has-error':'' }}">
                                <label for="nama_supir" class="col-sm-2 control-label">Nama Supir *</label>
                                <div class="col-xs-6">
                                    {!! Form::text('nama_supir',null,['class' => 'form-control', 'id' => 'nama_supir']) !!}                                    
                                    {!! $errors->first('nama_supir','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('berat_gross')?' has-error':'' }}">
                                <label for="berat_gross" class="col-sm-2 control-label">Berat Gross *</label>
                                <div class="col-xs-6">
                                    {!! Form::text('berat_gross',null,['class' => 'form-control', 'id' => 'berat_gross']) !!}                                    
                                    {!! $errors->first('berat_gross','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('berat_tara')?' has-error':'' }}">
                                <label for="berat_tara" class="col-sm-2 control-label">Berat Tara</label>
                                <div class="col-xs-6">
                                    {!! Form::text('berat_tara',null,['class' => 'form-control', 'id' => 'berat_tara']) !!}                                    
                                    {!! $errors->first('berat_tara','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('berat_netto')?' has-error':'' }}">
                                <label for="berat_netto" class="col-sm-2 control-label">Berat Netto</label>
                                <div class="col-xs-6">
                                    {!! Form::text('berat_netto',null,['class' => 'form-control', 'id' => 'berat_netto', 'readonly' => 'readonly']) !!}                                    
                                    {!! $errors->first('berat_netto','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('sj')?' has-error':'' }}">
                                <label for="sj" class="col-sm-2 control-label">Surat Jalan</label>
                                <div class="col-xs-10">
                                    {!! Form::text('sj',null,['class' => 'form-control', 'id' => 'sj']) !!}                                    
                                    {!! $errors->first('sj','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('po')?' has-error':'' }}">
                                <label for="po" class="col-sm-2 control-label">No. PO</label>
                                <div class="col-xs-10">
                                    {!! Form::text('po',null,['class' => 'form-control', 'id' => 'po']) !!}                                    
                                    {!! $errors->first('po','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('catatan')?' has-error':'' }}">
                                <label for="catatan" class="col-sm-2 control-label">Catatan</label>
                                <div class="col-xs-10">
                                    {!! Form::text('catatan',null,['class' => 'form-control', 'id' => 'catatansb2']) !!}                                    
                                    {!! $errors->first('catatan','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>Simpan</button>
                            <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>Reset</button>
                            {!! Form::close() !!}
                            <a href="{{route('timbangan')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>Kembali</a>
                        </div>
                        
                    </div>                     
                </div>
            </div>
        </div>
@endsection