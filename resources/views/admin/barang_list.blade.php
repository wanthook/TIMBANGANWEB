@extends('sb2.admsb2')

@section('additional_style')
    <!-- DataTables CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
@endsection

@section('additional_js')
    <!-- DataTables Plugin JavaScript -->
    <script src="{{asset('/assets/sb2/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
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
                    "url"       : "{{ route('jenisbarang.tabel') }}",
                    "type"      : 'POST'
//                    data: function (d) {
//                        d.mesin     = jQuery('#cmbMesin').val();
//                        d.startdate = jQuery('#txtStartDate').val();
//                        d.enddate   = jQuery('#txtEndDate').val();
//                    }
                },
                "columns"           :
                [
                    { data    : "action", name: "action", orderable: false, searchable: false},
                    { data    : "kode", name: "kode" },
                    { data    : "nama_barang", name: "nama_barang" },             
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
        });
    </script>
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
                            List Jenis Barang                            
                        </div>
                        <div class="panel-body">
                            <div class="pull-right">
                                <a href="{{route('jenisbarang.add')}}" class="btn btn-success btn-sm"><i class="fa fa-plus-square "></i></a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" id="tableId" class="table table-striped table-hover">
                                {{--*/
                                $arrHead = array('Action',
                                                 'Kode',
                                                 'Nama Barang',
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