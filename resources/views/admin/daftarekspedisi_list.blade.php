@extends('sb2.admsb2')

@section('additional_style')
    <!-- DataTables CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
    <!-- Select2 CSS -->
<!--    <link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2-bootstrap.css')}}" rel="stylesheet">-->
    <!-- datetimepicker bootstrap CSS -->
    <link href="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <!--typeahead -->
    <link href="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.css')}}" rel="stylesheet">
    <style>
        th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            width: 100%;   
            font-size: 10pt;
        }
    </style>
@endsection

@section('additional_js')
    <!-- DataTables Plugin JavaScript -->
    <script src="{{asset('/assets/sb2/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
    <!--<script src="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.min.js')}}"></script>-->
    <script src="{{asset('/assets/sb2/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.bundle.min.js')}}"></script>
    <script>
        var dataTable = null;
        $(document).ready(function(e)
        {
            $.ajaxSetup({
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'}
            });
            
            dataTable = $('#tableId').DataTable({
                "sPaginationType": "full_numbers",
                "searching":false,
                "ordering": true,
                "scrollY": 400,
                "scrollX": true,
                "deferRender": true,
                "processing": true,
                "serverSide": true,
                "lengthMenu": [100, 500, 1000, 1500, 2000 ],
                "ajax":
                {
                    "url"       : "{{ route('daftarekspedisi.tabel') }}",
                    "type"      : 'POST',
                    data: function (d) {
                        d.txtSearch     = $('#txtSearch').val();
                        d.txtTanggalDaftar      = $('#txtTanggalDaftar').val();
                        d.cmbRelasi     = $('#cmbRelasi').val();                        
                    }
                },
                "columns"           :
                [
                    { data    : "action", name: "action", orderable: false, searchable: false},
                    { data    : "tanggal_pesan", name: "tanggal_pesan" },
                    { data    : "no_pol", name: "no_pol" },
                    { data    : "relasi", name: "relasi" },
                    { data    : "nama_supir", name: "nama_supir" },
                    { data    : "create_date", name: "create_date" }

                ],
                "drawCallback": function( settings, json ) 
                {
                    $('.deleterow').on('click',function(e){
                        e.preventDefault();
                        var _this	= jQuery(this);
                        if(confirm('Apakah Anda yakin menghapus data ini?'))
                        {
                            var url = jQuery(this).attr('href');
                            $.ajax({
                                url: url,
                                type: 'POST',
                                dataType: 'json',
                                data: {_method: 'DELETE'},
                                success: function (data) {
                                    if(data.status==1)
                                    {
                                        _this.parents('tr').fadeOut(function(){
                                            _this.remove();
                                        });
                                    }
                                   else
                                   {
                                    }
                                }
                            });
                        }

                        return false;
                    });
                }
            });
            
            $('#txtTanggalDaftar').datetimepicker({
                format: "DD-MM-YYYY"
            });
            
            $('#btnSearch').on('click',function(e)
            {
                dataTable.ajax.reload();
            });
            
            $('#cmbRelasi').typeahead(null, {
                displayKey: 'value',
                source: relasiauto
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
    </script>
@endsection

@section('alert_content')
@if(session('msg'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('msg') }}
    </div>
@endif
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-send-o"></i>
                        </span>&nbsp;&nbsp;Pendaftaran Ekspedisi
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            List Pendaftaran Ekspedisi
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="{{route('daftarekspedisi.add')}}" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="pull-left form-inline">
                                {!! Form::text('txtSearch',null,['class' => 'form-control', 'id' => 'txtSearch', 'placeholder' => 'No. Polisi/Nama Supir']) !!}
                                {!! Form::text('cmbRelasi',null,['class' => 'form-control', 'id' => 'cmbRelasi', 'placeholder' => 'Relasi']) !!} 
                                <div class="input-group date">
                                    {!! Form::text('txtTanggalDaftar',null,['class' => 'form-control', 'id' => 'txtTanggalDaftar', 'placeholder' => 'Tanggal Daftar', 'style' => 'width:150px;']) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <button class="btn btn-primary btn-sm" id="btnSearch"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" id="tableId" class="table table-striped table-hover">
                                {{--*/
                                $arrHead = array('Action',
                                                 'Tanggal Pesan',
                                                 'Nomor Polisi',
                                                 'Relasi',
                                                 'Nama Supir',                                  
                                                 'Create Date'
                                                 )
                                /*--}}
                                <thead>
                                    <tr>
                                        {{--*/  $col = 0  /*--}}
                                        @for ($i = 0; $i < count($arrHead); $i++)
                                            <th class="head{{$col}}">{{$arrHead[$i]}}</th>
                                            @if($col==0) 
                                                {{--*/ $col = 1 /*--}}
                                            @else
                                                {{--*/ $col = 0 /*--}}
                                            @endif
                                        @endfor  
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
@endsection