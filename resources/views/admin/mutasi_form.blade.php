<?php
$label  = "";

if(isset($param))
{
    switch($param)
    {
        case 'bng': {$label .= 'Benang'; break;}
        case 'kps': {$label .= 'Kapas'; break;}
        case 'wst': {$label .= 'Waste'; break;}
        case 'hdk': {$label .= 'Handuk'; break;}
        case 'kan': {$label .= 'Kain'; break;}
        case 'lmb': {$label .= 'Limbah'; break;}
    }
}

if(isset($inout))
{
    switch($inout)
    {
        case 'in': $label .= ' Masuk'; break;
        case 'out': $label .= ' Keluar'; break;
    }
}
?>

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
        
        $('#partai').typeahead(null, {
            displayKey: 'value',
            source: partaiauto
        });
        
        $('#tiket').typeahead(null, {
            displayKey: 'value',
            source: tiketauto
        });
        
        $('#tiket').bind('typeahead:selected', function(obj, datum, name) { 
//            console.log(datum);
            if(datum)
            {
                $('#jenis').val(datum.jenis);
                $('#tanggal').val(datum.tanggal);
                $('#no_pol').val(datum.no_pol);
                $('#timbangan_brutto').val(datum.brutto);
                $('#timbangan_tara').val(datum.tara);
                $('#timbangan_netto').val(datum.netto);
                $('#timbangan_id').val(datum.timbangan_id);
            }
        });
        
        $('#bal_list,#bal_terima,#packing_brutto,#packing_tara,#timbanganman_brutto,#timbanganman_tara').on('keyup',function(e)
        {
            hBalSelisih();
            hTaraBl();
            hNettoBl();
            hNettoTU();
            hNetto();
            hSelisih();
        });
        
    });
    
    var partaiauto = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.value)
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "{{route('mutasi.autopartai',[$inout,$param])}}",
            prepare: function (query, settings) 
            {
                settings.type = "post";
                settings.dataType = 'json';
                settings.data = {q: query};

                return settings;
             }
        }
    });
    
    var tiketauto = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d)
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "{{route('timbangan.autotiket')}}",
            prepare: function (query, settings) 
            {
                settings.type = "post";
                settings.dataType = 'json';
                settings.data = {q: query,k:'{{$param}}'};

                return settings;
             }
        }
    });
    
    var hBalSelisih = function()
    {
        var bal_list = parseFloat($('#bal_list').val());
        var bal_terima = parseFloat($('#bal_terima').val());

        if(bal_list && bal_terima)
        {
            $('#bal_selisih').val(bal_list-bal_terima);
        }
    };
    
    var hTaraBl = function()
    {
        var bal_list = parseFloat($('#bal_list').val());
        var packing_tara = parseFloat($('#packing_tara').val());

        if(bal_list && packing_tara)
        {
            $('#packing_tarabl').val((packing_tara/bal_list).toFixed(2));
        }
    };
    
    var hNettoBl = function()
    {
        var packing_brutto = parseFloat($('#packing_brutto').val());
        var packing_tara = parseFloat($('#packing_tara').val());

        if(packing_brutto && packing_tara)
        {
            $('#packing_subnetto').val((packing_brutto-packing_tara).toFixed(3));
        }
    };
    
    var hNettoTU = function()
    {
        var timbanganman_brutto = parseFloat($('#timbanganman_brutto').val());
        var timbanganman_tara = parseFloat($('#timbanganman_tara').val());

        if(timbanganman_brutto && timbanganman_tara)
        {
            $('#timbanganman_netto').val((timbanganman_brutto-timbanganman_tara).toFixed(3));
        }
    };
    
    var hNetto = function()
    {
        var timbangan_netto = parseFloat($('#timbangan_netto').val());
        var packing_tara = parseFloat($('#packing_tara').val());

        if(timbangan_netto && packing_tara)
        {
            $('#netto').val((timbangan_netto-packing_tara).toFixed(3));
        }
    };
    
    var hSelisih = function()
    {
        var netto = parseFloat($('#netto').val());
        var packing_subnetto = parseFloat($('#packing_subnetto').val());

        if(netto && packing_subnetto)
        {
            $('#selisih').val((netto-packing_subnetto).toFixed(3));
            $('#persen').val(((netto-packing_subnetto)/packing_subnetto*100).toFixed(3));
        }
    };
    
    var hPList = function()
    {
        var bal_list = parseFloat($('#bal_list').val());
        var packing_brutto = parseFloat($('#packing_brutto').val());

        if(bal_list && packing_brutto)
        {
            $('#packing_tarabl').val((bal_list/bal_terima).toFixed(2));
        }
    };
    
</script>
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-exchange"></i>
                        </span>&nbsp;&nbsp;<a href="{{route('mutasi',[$inout,$param])}}">Mutasi {{ $label }}</a>
                        &nbsp;>&nbsp;Form Mutasi {{ $label }}
                    </h4>
                </div>     
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Form Mutasi {{ $label }}
                        </div>                        
                        @if(!isset($var->id))
                            {!! Form::model($var, ['url' => route('mutasi.save',[$inout,$param]),'class' => 'form-horizontal']) !!}
                        @else
                            {!! Form::model($var,['method' => 'PATCH', 'route' => ['mutasi.change',$inout,$param,$var->id],'class' => 'form-horizontal']) !!}
                        @endif
                        <div class="panel-body">
                            <div class="form-group{{ $errors->has('tipe')?' has-error':'' }}">
                                <label for="tipe" class="col-sm-2 control-label">Tipe *</label>
<!--                                <div class="col-xs-6">
                                    {!! Form::text('tipe',null,['class' => 'form-control typeahead', 'id' => 'tipe', 'placeholder' => 'Tipe']) !!}
                                    {!! $errors->first('tipe','<span class="help-block">:message</span>') !!}
                                </div>-->
                                <fieldset readonly>
                                <label class="col-xs-2">
                                    {!! Form::radio('tipe','import',null,['readonly'=>'readonly']) !!}Import
                                </label>
                                <label class="col-xs-2">
                                    {!! Form::radio('tipe','lokal',null,['readonly'=>'readonly']) !!}Lokal
                                </label>
                                <label class="col-xs-2">
                                    {!! Form::radio('tipe','export',null,['readonly'=>'readonly']) !!}Export
                                </label>
                                </fieldset>
                            </div>
                            <div class="form-group{{ $errors->has('partai')?' has-error':'' }}">
                                <label for="partai" class="col-sm-2 control-label">Partai *</label>
                                <div class="col-xs-6">
                                    {!! Form::text('partai',null,['class' => 'form-control typeahead', 'id' => 'partai', 'placeholder' => 'Partai']) !!}                                    
                                    {!! $errors->first('partai','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>                            
                            <!-- -->
                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <label class="col-xs-2">BL/P.List *</label>
                                <label class="col-xs-2">Terima *</label>
                                <label class="col-xs-2">Selisih *</label>
                                <label class="col-xs-2">Tara BL *</label>
                            </div>      
                            <div class="form-group">
                                <label class="col-sm-2">Jumlah Bal</label>
                                <div class="col-xs-2">
                                    {!! Form::text('bal_list',null,['class' => 'form-control', 'id' => 'bal_list', 'placeholder' => '0']) !!}
                                    {!! $errors->first('bal_list','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('bal_terima',null,['class' => 'form-control', 'id' => 'bal_terima', 'placeholder' => '0']) !!}
                                    {!! $errors->first('bal_terima','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('bal_selisih',null,['class' => 'form-control', 'id' => 'bal_selisih', 'placeholder' => '0', 'readonly'=>'readonly']) !!}
                                    {!! $errors->first('bal_selisih','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('packing_tarabl',null,['class' => 'form-control', 'id' => 'packing_tarabl', 'placeholder' => '0', 'readonly'=>'readonly']) !!}
                                    {!! $errors->first('packing_tarabl','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>                            
                            <h4 class="page-header">Info Timbangan</h4>
                            {!! form::hidden('jenis',null,['id' => 'jenis']) !!}
                            {!! form::hidden('timbangan_id',null,['id' => 'timbangan_id']) !!}
                            <div class="form-group{{ $errors->has('tiket')?' has-error':'' }}">
                                <label for="tiket" class="col-sm-2 control-label">Tiket *</label>
                                <div class="col-xs-10">
                                    {!! Form::text('tiket',null,['class' => 'form-control typeahead', 'id' => 'tiket', 'placeholder' => 'Tiket']) !!}
                                    {!! $errors->first('tiket','<span class="help-block">:message</span>') !!}
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('no_container')?' has-error':'' }}">
                                <label for="no_container" class="col-sm-2 control-label">No. Container *</label>
                                <div class="col-xs-10">
                                    {!! Form::text('no_container',null,['class' => 'form-control', 'id' => 'no_container', 'placeholder' => 'No. Container']) !!}
                                    {!! $errors->first('no_container','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal')?' has-error':'' }}">
                                <label for="tanggal" class="col-sm-2 control-label">Tgl. Timbang *</label>
                                <div class="col-xs-4">
                                    <div class="input-group date">
                                        {!! Form::text('tanggal',null,['class' => 'form-control', 'id' => 'tanggal', 'placeholder' => 'Tanggal Timbang', 'readonly'=>'readonly']) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        {!! $errors->first('tanggal','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('no_pol')?' has-error':'' }}">
                                <label for="no_pol" class="col-sm-2 control-label">No. Kendaraan *</label>
                                <div class="col-xs-3">
                                    {!! Form::text('no_pol',null,['class' => 'form-control', 'id' => 'no_pol', 'readonly'=>'readonly']) !!}                                    
                                    {!! $errors->first('no_pol','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <label class="col-xs-2">Gross (KG)</label>
                                <label class="col-xs-2">Tara (KG)</label>
                                <label class="col-xs-2">Netto (KG)</label>
                            </div>      
                            <div class="form-group">
                                <label class="col-sm-2">Timbangan *</label>
                                <div class="col-xs-2">
                                    {!! Form::text('timbangan_brutto',null,['class' => 'form-control', 'id' => 'timbangan_brutto', 'readonly'=>'readonly', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('timbangan_brutto','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('timbangan_tara',null,['class' => 'form-control', 'id' => 'timbangan_tara', 'readonly'=>'readonly', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('timbangan_tara','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('timbangan_netto',null,['class' => 'form-control', 'id' => 'timbangan_netto', 'readonly'=>'readonly', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('timbangan_netto','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>   
                            <div class="form-group">
                                <label class="col-sm-2">BL/Packing List *</label>
                                <div class="col-xs-2">
                                    {!! Form::text('packing_brutto',null,['class' => 'form-control', 'id' => 'packing_brutto', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('packing_brutto','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('packing_tara',null,['class' => 'form-control', 'id' => 'packing_tara', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('packing_tara','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('packing_subnetto',null,['class' => 'form-control', 'id' => 'packing_subnetto', 'readonly'=>'readonly', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('packing_subnetto','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>   
                            <div class="form-group">
                                <label class="col-sm-2">Timbang Ulang</label>
                                <div class="col-xs-2">
                                    {!! Form::text('timbanganman_brutto',null,['class' => 'form-control', 'id' => 'timbanganman_brutto', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('timbanganman_brutto','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('timbanganman_tara',null,['class' => 'form-control', 'id' => 'timbanganman_tara', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('timbanganman_tara','<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('timbanganman_netto',null,['class' => 'form-control', 'id' => 'timbanganman_netto', 'readonly'=>'readonly', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('timbanganman_netto','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('netto')?' has-error':'' }}">
                                <label for="netto" class="col-sm-2 control-label">Netto (KG)</label>
                                <div class="col-xs-3">
                                    {!! Form::text('netto',null,['class' => 'form-control', 'id' => 'netto', 'readonly'=>'readonly', 'placeholder' => '0']) !!}                                    
                                    {!! $errors->first('netto','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('selisih')?' has-error':'' }}">
                                <label for="selisih" class="col-sm-2 control-label">Selisih (KG)</label>
                                <div class="col-xs-3">
                                    {!! Form::text('selisih',null,['class' => 'form-control', 'id' => 'selisih', 'readonly'=>'readonly', 'placeholder' => '0']) !!}
                                    {!! $errors->first('selisih','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('persen')?' has-error':'' }}">
                                <label for="persen" class="col-sm-2 control-label">Selisih (%)</label>
                                <div class="col-xs-3">
                                    {!! Form::text('persen',null,['class' => 'form-control', 'id' => 'persen', 'readonly'=>'readonly', 'placeholder' => '0']) !!}
                                    {!! $errors->first('persen','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('keterangan')?' has-error':'' }}">
                                <label for="keterangan" class="col-sm-2 control-label">Keterangan *</label>
                                <div class="col-xs-10">
                                    {!! Form::text('keterangan',null,['class' => 'form-control', 'id' => 'keterangan', 'placeholder' => 'Keterangan']) !!}
                                    {!! $errors->first('keterangan','<span class="help-block">:message</span>') !!}
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