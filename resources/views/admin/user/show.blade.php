@extends('layouts.app')

@section('additional_style')
@endsection

@push('additional_js')
<script src="{{ asset('/assets/js/jquery.dataTables.1.10.min.js') }}"></script>     
<script>
    var App = function(){
        this.dataTable  = null;
        this.DOM        = this.getDOM();
        this.table();
    }
    
    App.prototype.getDOM    = function(){
        return {
            tableId         : jQuery('#tableId')
        }
    }
    
    App.prototype.table     = function(){
        var _this   = this;

        this.dataTable = _this.DOM.tableId.DataTable({
            "sPaginationType": "full_numbers",
            "searching":true,
            "ordering": true,
            "scrollY": 400,
            "scrollX": true,
            "deferRender": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [100, 500, 1000, 1500, 2000 ],
            "ajax":
            {
                "url"       : "{{ route('user.tabel') }}",
                "type"      : 'POST',
                "headers"   : {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            "columns"           :
            [
                { data    : "action", name: "action", orderable: false, searchable: false},
                { data    : "username", name: "username" },
                { data    : "name", name: "name" },
                { data    : "email", name: "email" },
                { data    : "type", name: "type" },
                { data    : "created_at", name: "created_at" }

            ],
            "drawCallback": function( settings, json ) 
            {
                jQuery('.deleterow').on('click',function(e){
                    e.preventDefault();
                    var _this	= jQuery(this);
                    if(confirm('Apakah anda yakin ingin menghapus data ini?'))
                    {
                        var url = jQuery(this).attr('href');
                        jQuery.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            headers   : 
                            {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {_method: 'PATCH'}
                        }).success(function (data) {
                            if(data.status==1)
                            {
                                _this.parents('tr').fadeOut(function(){
                                    _this.remove();
                                });

                                jQuery.alerts.dialogClass = 'alert-info';
                                jAlert(data.msg, 'Informasi', function()
                                {
                                    jQuery.alerts.dialogClass = null; // reset to default
                                });
                           }
                           else
                           {
                               jQuery.alerts.dialogClass = 'alert-warning';
                                jAlert(data.msg, 'Perhatian', function()
                                {
                                    jQuery.alerts.dialogClass = null; // reset to default
                                });
                            }
                        });
                    }
                    
                    return false;
                });
            }
        });
    }
    
    new App();
</script>
@endpush

@section('navigator')
<li><a href="{{ route('home.root') }}"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
<li>User</li>            
@endsection

@section('pageheader')
<div class="pageicon"><span class="iconfa-user"></span></div>
<div class="pagetitle">
    <h5>List Master User</h5>
    <h1>User</h1>
</div>
@endsection

@section('maincontent')
<div class="headtitle">    
    <div class="btn-group">
        <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('user.tambah') }}"><i class="iconfa-plus-sign"></i>&nbsp;Tambah User</a>
            </li>
        </ul>
    </div>
    <h4 class="widgettitle">Tabel List User</h4>
    
    <table id="tableId" class="table table-bordered responsive">
        {{--*/
        $arrHead = array('&nbsp;',
                         'Username',
                         'Nama',
                         'Email',  
                         'Tipe',                         
                         'Tanggal Buat'
                         )
        /*--}}
        <colgroup>
        {{--*/ $col = 0 /*--}}
        @for ($i = 0; $i < count($arrHead); $i++)
            <col class="con{{$col}}" />
            @if($col==0) 
                {{--*/ $col = 1 /*--}}
            @else
                {{--*/ $col = 0 /*--}}
            @endif
        @endfor   
        </colgroup>
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
@endsection