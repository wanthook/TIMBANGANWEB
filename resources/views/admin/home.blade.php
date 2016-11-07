@extends('sb2.admsb2')

@section('additional_style')
    <!-- DataTables CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2-bootstrap.css')}}" rel="stylesheet">
    <!-- datetimepicker bootstrap CSS -->
    <link href="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
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
    <script src="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
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
                    "url"       : "{{ route('timbangan.tabel') }}",
                    "type"      : 'POST',
                    data: function (d) {
                        d.txtSearch     = $('#txtSearch').val();
                        d.txtSDate      = $('#txtSDate').val();
                        d.txtEDate      = $('#txtEDate').val();
                        d.cmbBarang     = $('#cmbBarang').val();                        
                    }
                },
                "columns"           :
                [
                    { data    : "tiket", name: "tiket" },
                    { data    : "barang[0].nama_barang", name: "nama_barang" },
                    { data    : "tanggal_masuk", name: "tanggal_masuk" },   
                    { data    : "jam_masuk", name: "jam_masuk" },
                    { data    : "tanggal_keluar", name: "tanggal_keluar" },
                    { data    : "jam_keluar", name: "jam_keluar" },
                    { data    : "no_pol", name: "no_pol" },
                    { data    : "relasi", name: "relasi" },
                    { data    : "nama_supir", name: "nama_supir" },
                    { data    : "berat_gross", name: "berat_gross" },
                    { data    : "berat_tara", name: "berat_tara" },
                    { data    : "berat_netto", name: "berat_netto" },
                    { data    : "catatan", name: "catatan" },             
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
                                data: {_method: 'PATCH'}
                            }).success(function (data) {
                                if(data.status==1)
                                {
                                    _this.parents('tr').fadeOut(function(){
                                        _this.remove();
                                    });
                               }
                               else
                               {
                                }
                            });
                        }

                        return false;
                    });
                }
            });
            
            $('#txtSDate,#txtEDate').datetimepicker({
                format: "DD-MM-YYYY"
            });
            
            $('#cmbBarang').select2({
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
            
            $('#btnSearch').on('click',function(e)
            {
                dataTable.ajax.reload();
            });
            
            
        });
        setInterval(function()
            { 
                dataTable.ajax.reload() 
            }, 60000);
    </script>
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-dashboard"></i>
                        </span>&nbsp;&nbsp;Dashboard
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            @if(session('msg'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('msg') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Live Monitoring Timbangan                            
                        </div>
                        <div class="panel-body">
                            <div class="pull-left form-inline">
                                {!! Form::text('txtSearch',null,['class' => 'form-control', 'id' => 'txtSearch', 'placeholder' => 'Tiket/No Pol/Relasi/Supir']) !!}
                                {!! Form::hidden('cmbBarang',null,['class' => 'form-control', 'id' => 'cmbBarang', 'style' => 'width:150px;']) !!} 
                                
                                <div class="input-group date">
                                    {!! Form::text('txtSDate',null,['class' => 'form-control', 'id' => 'txtSDate', 'placeholder' => 'Tanggal Awal', 'style' => 'width:150px;']) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <div class="input-group date">
                                    {!! Form::text('txtEDate',null,['class' => 'form-control', 'id' => 'txtEDate', 'placeholder' => 'Tanggal Akhir', 'style' => 'width:150px;']) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <button class="btn btn-primary btn-sm" id="btnSearch"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" id="tableId" class="table table-striped table-hover">
                                {{--*/
                                $arrHead = array('Tiket',
                                                 'Nama Barang',
                                                 'Tgl Masuk',
                                                 'Jam Masuk',
                                                 'Tgl Keluar',
                                                 'Jam Keluar',
                                                 'NoPol',
                                                 'Relasi',
                                                 'Supir',
                                                 'Gross (KG)',
                                                 'Tara (KG)',
                                                 'Netto (KG)',
                                                 'Note',                                                 
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