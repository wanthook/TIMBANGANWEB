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
                        &nbsp;>&nbsp;Form Timbangan Upload                      
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Form Timbangan Upload                          
                        </div>      
                        {!! Form::open(array('url' => route('timbangan.doupload'),'class' => 'stdform','files'=> true )) !!}
                        <div class="panel-body">
                            <div class="form-group{{ $errors->has('timbangan_excel')?' has-error':'' }}">
                                <label for="kode" class="col-sm-2 control-label">Fileupload *</label>
                                <div class="col-xs-4">
                                    {!! Form::file('timbangan_excel',['id' => 'timbangan_excel']) !!}
                                </div>
                                {!! $errors->first('timbangan_excel','<span class="help-block">:message</span>') !!}
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