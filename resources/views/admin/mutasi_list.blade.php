<?php
$label  = "";

$arrLokal   = array('inkps','inbng','inwst','outkps','outbng','outhdk','outwst','outkan','outlmb');
$arrExport  = array('outbng','outhdk','outwst','outkan');
$arrImport  = array('inkps');

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
    <!--<script src="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>-->
    <!--<script src="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.min.js')}}"></script>-->
    <script src="{{asset('/assets/sb2/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.bundle.min.js')}}"></script>
    <script>
        <?php
        //lokal semua        
        if(in_array($inout.$param, $arrLokal))
        {
            ?>
            var dataTableLokal = null;
            <?php
        }
        //Import semua        
        if(in_array($inout.$param, $arrImport))
        {
            ?>
            var dataTableImport = null;
            <?php
        }
        //Export semua        
        if(in_array($inout.$param, $arrExport))
        {
            ?>
            var dataTableExport = null;
            <?php
        }
        ?>
        
        $(document).ready(function(e)
        {
            $.ajaxSetup({
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'}
            });
            
            <?php
            //lokal semua        
            if(in_array($inout.$param, $arrLokal))
            {
                ?>
                dataTableLokal = dataTables('tableIdLokal','lokal');
                $('#btnSearchLokal').on('click',function(e)
                {
                    dataTableLokal.ajax.reload();
                });
                <?php
            }
            //Import semua        
            if(in_array($inout.$param, $arrImport))
            {
                ?>
                dataTableImport = dataTables('tableIdImport','import');
                $('#btnSearchImport').on('click',function(e)
                {
                    dataTableImport.ajax.reload();
                });
                <?php
            }
            //Export semua        
            if(in_array($inout.$param, $arrExport))
            {
                ?>
                dataTableExport = dataTables('tableIdExport','export');
                $('#btnSearchExport').on('click',function(e)
                {
                    dataTableExport.ajax.reload();
                });
                <?php
            }
            ?>
            $('.txtTanggal').datetimepicker({
                format: "DD-MM-YYYY"
            });
            $('.cmbPartai').typeahead(null, {
                displayKey: 'value',
                source: partaiauto
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
        
        var dataTables = function(id,tipe)
        {
            return $('#'+id).DataTable({
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
                    "url"       : "{{ route('mutasi.tabel',[$inout,$param]) }}",
                    "type"      : 'POST',
                    data: function (d) {
                        d.txtSearch         = $('#txtSearchLokal').val();
                        d.txtTanggalStart   = $('#txtTanggalStartLokal').val();
                        d.txtTanggalEnd     = $('#txtTanggalEndLokal').val();
                        d.cmbPartai         = $('#cmbPartaiLokal').val();
                        d.tipe             = tipe;
                    }
                },
                "columns"           :
                [
                    { data    : "action", name: "action", orderable: false, searchable: false},
                    { data    : "tanggal", name: "tanggal" },
                    { data    : "partai", name: "partai" },
                    { data    : "tiket", name: "tiket" },
                    { data    : "no_pol", name: "no_pol" },
//                    { data    : "index_mobil", name: "index_mobil" },
                    { data    : "bal_list", name: "bal_list" },
                    { data    : "bal_terima", name: "bal_terima" },
                    { data    : "bal_selisih", name: "bal_selisih" },
                    { data    : "packing_tarabl", name: "packing_tarabl" },
                    { data    : "packing_brutto", name: "packing_brutto" },
                    { data    : "packing_tara", name: "packing_tara" },
                    { data    : "packing_subnetto", name: "packing_subnetto" },
                    { data    : "timbangan_brutto", name: "timbangan_brutto" },
                    { data    : "timbangan_tara", name: "timbangan_tara" },
                    { data    : "timbangan_netto", name: "timbangan_netto" },
                    { data    : "netto", name: "netto" },
                    { data    : "selisih", name: "selisih" },
                    { data    : "persen", name: "persen" },
                    { data    : "keterangan", name: "keterangan" },
                    { data    : "timbanganman_brutto", name: "timbanganman_brutto" },
                    { data    : "timbanganman_tara", name: "timbanganman_tara" },
                    { data    : "timbanganman_netto", name: "timbanganman_netto" },
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
        }
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
                            <i class="fa fa-exchange"></i>
                        </span>&nbsp;&nbsp;Mutasi {{ $label }}
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            List Mutasi {{ $label }}                            
                        </div>
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <?php
                                $atv    = ' class="active"';
                                //lokal semua        
                                if(in_array($inout.$param, $arrLokal))
                                {
                                    ?>
                                    <li<?php echo $atv;$atv=""; ?>><a href="#lokal" data-toggle="tab">Lokal</a>
                                    </li>
                                    <?php
                                }
                                //Import semua        
                                if(in_array($inout.$param, $arrImport))
                                {
                                    ?>
                                    <li<?php echo $atv;$atv=""; ?>><a href="#import" data-toggle="tab">Import</a>
                                    </li>
                                    <?php
                                }
                                //Export semua        
                                if(in_array($inout.$param, $arrExport))
                                {
                                    ?>
                                    <li<?php echo $atv;$atv=""; ?>><a href="#export" data-toggle="tab">Export</a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <!-- Tab panes -->
                             {{--*/
                            $arrHead = array('Action',
                                             'Tanggal Mutasi',
                                             'Partai',
                                             'Tiket',
                                             'No. Mobil',
                                             'Bal P.List',
                                             'Bal Terima',
                                             'Bal Selisih',
                                             'P.List Tara Bal',
                                             'P.List Brutto',
                                             'P.List Tara',
                                             'P.List Sub Netto',
                                             'Timbangan Brutto',
                                             'Timbangan Tara',
                                             'Timbangan Sub Netto',
                                             'Netto',
                                             'Selisih',
                                             '%',
                                             'Keterangan',
                                             'Manual Brutto',
                                             'Manual Tara',
                                             'Manual Netto',
                                             'Create Date'
                                             )
                            /*--}}
                            <div class="tab-content">
                                <?php
                                $atvX    = ' active';
                                //lokal semua        
                                if(in_array($inout.$param, $arrLokal))
                                {
                                    ?>
                                    <div class="tab-pane fade in <?php echo $atvX;$atvX=""; ?>" id="lokal">
                                         <div class="form-inline pull-right">
                                            <div class="btn-group">
                                                <a href="{{route('mutasi.add',[$inout,$param,'lokal'])}}" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Tambah</a>
                                            </div>
                                        </div>
                                        <h4>List Lokal</h4>
                                        <div class="form-inline">
                                            {!! Form::text('txtSearchLokal',null,['class' => 'form-control input-sm', 'id' => 'txtSearchLokal', 'placeholder' => 'No. Polisi/Tiket']) !!}
                                            {!! Form::text('cmbPartaiLokal',null,['class' => 'form-control cmbPartai input-sm', 'id' => 'cmbPartaiLokal', 'placeholder' => 'Partai']) !!} 
                                            <div class="input-group date">
                                                {!! Form::text('txtTanggalStartLokal',null,['class' => 'form-control txtTanggal input-sm', 'id' => 'txtTanggalStartLokal', 'placeholder' => 'Tanggal Awal', 'style' => 'width:150px;']) !!}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            S/D
                                            <div class="input-group date">
                                                {!! Form::text('txtTanggalEndLokal',null,['class' => 'form-control txtTanggal input-sm', 'id' => 'txtTanggalEndLokal', 'placeholder' => 'Tanggal Akhir', 'style' => 'width:150px;']) !!}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <button class="btn btn-primary btn-sm" id="btnSearchLokal"><i class="fa fa-search"></i></button>
                                        </div>
                                        <div class="table-responsive">
                                            <table width="100%" id="tableIdLokal" class="table table-striped table-hover">
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
                                    <?php
                                }
                                //Import semua        
                                if(in_array($inout.$param, $arrImport))
                                {
                                    ?>
                                    <div class="tab-pane fade in <?php echo $atvX;$atvX=""; ?>" id="import">
                                        <div class="form-inline pull-right">
                                            <div class="btn-group">
                                                <a href="{{route('mutasi.add',[$inout,$param,'import'])}}" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Tambah</a>
                                            </div>
                                        </div>
                                        <h4>List Import</h4>
                                        <div class="form-inline">
                                            {!! Form::text('txtSearchImport',null,['class' => 'form-control input-sm', 'id' => 'txtSearchImport', 'placeholder' => 'No. Polisi/Tiket']) !!}
                                            {!! Form::text('cmbPartaiImport',null,['class' => 'form-control cmbPartai input-sm', 'id' => 'cmbPartaiImport', 'placeholder' => 'Partai']) !!} 
                                            <div class="input-group date">
                                                {!! Form::text('txtTanggalStartImport',null,['class' => 'form-control txtTanggal input-sm', 'id' => 'txtTanggalStartImport', 'placeholder' => 'Tanggal Awal', 'style' => 'width:150px;']) !!}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            S/D
                                            <div class="input-group date">
                                                {!! Form::text('txtTanggalEndImport',null,['class' => 'form-control txtTanggal input-sm', 'id' => 'txtTanggalEndImport', 'placeholder' => 'Tanggal Akhir', 'style' => 'width:150px;']) !!}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <button class="btn btn-primary btn-sm" id="btnSearchImport"><i class="fa fa-search"></i></button>
                                        </div>
                                        <div class="table-responsive">
                                            <table width="100%" id="tableIdImport" class="table table-striped table-hover">
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
                                    <?php
                                }
                                //Export semua        
                                if(in_array($inout.$param, $arrExport))
                                {
                                    ?>
                                    <div class="tab-pane fade in <?php echo $atvX;$atvX=""; ?>" id="export">
                                        <div class="form-inline pull-right">
                                            <div class="btn-group">
                                                <a href="{{route('mutasi.add',[$inout,$param,'export'])}}" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Tambah</a>
                                            </div>
                                        </div>
                                        <h4>List Export</h4>
                                        <div class="form-inline">
                                            {!! Form::text('txtSearchExport',null,['class' => 'form-control input-sm', 'id' => 'txtSearchExport', 'placeholder' => 'No. Polisi/Tiket']) !!}
                                            {!! Form::text('cmbPartaiExport',null,['class' => 'form-control cmbPartai input-sm', 'id' => 'cmbPartaiExport', 'placeholder' => 'Partai']) !!} 
                                            <div class="input-group date">
                                                {!! Form::text('txtTanggalStartExport',null,['class' => 'form-control txtTanggal input-sm', 'id' => 'txtTanggalStartExport', 'placeholder' => 'Tanggal Awal', 'style' => 'width:150px;']) !!}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            S/D
                                            <div class="input-group date">
                                                {!! Form::text('txtTanggalEndExport',null,['class' => 'form-control txtTanggal input-sm', 'id' => 'txtTanggalEndExport', 'placeholder' => 'Tanggal Akhir', 'style' => 'width:150px;']) !!}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <button class="btn btn-primary btn-sm" id="btnSearchExport"><i class="fa fa-search"></i></button>
                                        </div>
                                        <div class="table-responsive">
                                            <table width="100%" id="tableIdExport" class="table table-striped table-hover">
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
                                    <?php
                                }
                                ?>
                            </div>
                        </div>                        
                    </div>                        
                </div>
            </div>
        </div>
@endsection