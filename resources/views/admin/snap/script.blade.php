<script src="{{ asset('/assets/js/select2.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.dataTables.1.10.min.js') }}"></script> 
<script src="{{ asset('/assets/js/bootstrap-timepicker.min.js') }}"></script> 
<!--<script src="{{ asset('/assets/js/formatter/dist/jquery.formatter.min.js') }}"></script>--> 
<script>
    var table = null;
    var i = 0;
    jQuery(document).ready(function()
    {
        jQuery.ajaxSetup({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'}
        });
        
        jQuery('#snap_tanggal').datepicker(
        {
            dateFormat:'yy-mm-dd'
        });
        
        jQuery('#mesin_id').select2({
            minimumInputLength: 0,
            ajax: 
            {
                url: "{{ route('mesin.selectdua') }}",
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
                        url: "{{ route('mesin.selectdua') }}",
                        dataType: 'json',
                        type: 'post',
                        data: {id: id}
                    }).done(function(data){ callback(data[0]);});
                }
            }
        });
        
        table = jQuery('#tableId').DataTable(
        {
            "searching":false,
            "ordering": false,
            "paging":   false,
            "scrollY": 400,
            "scrollX": true,
            "drawCallback": function( settings, json ) 
            {
                jQuery('.del').on('click',function(e){
                    e.preventDefault();
                    var _this	= jQuery(this);
                    _this.parents('tr').fadeOut(function(){
                        _this.remove();
                    });
                });
            }
        });
        
        jQuery('#addDetail').click(function(e)
        {
            e.preventDefault();
            
            formDetail("");
        });
        
        jQuery('#tableId tbody').on('keyup click','td', function(e)
        {
            lSnap(this);
            rSnap(this);
            breaksSnap(this);
            avgL();
            avgLS();
            avgR();
            avgRS();
            avgTB();
            avgTS();
            avgRest();
            avgFirstLast();
        });
    });
    
    var snap    = function(data)
    {
        var mesin_spindle = 0;
        
        if(jQuery('#mesin_id').select2('data') != null)
            mesin_spindle           = jQuery('#mesin_id').select2('data').mesin_spindle;
        
        return parseFloat((data / mesin_spindle) * 100).toFixed(2);
    }
    
    var lSnap   = function(tbl)
    {
        var parent  = jQuery(tbl).parent('tr');
        
        var snaps = parseInt(parent.find('.left').val());
        
        parent.find('.left_snap').val(snap(snaps));
    }
    
    var rSnap   = function(tbl)
    {
        var parent  = jQuery(tbl).parent('tr');
        
        var snaps = parseInt(parent.find('.right').val());
        
        parent.find('.right_snap').val(snap(snaps));
    }
    
    var breaksSnap      = function(tbl)
    {
        var parent  = jQuery(tbl).parent('tr');
        
        var l = parseInt(parent.find('.left').val());
        var r = parseInt(parent.find('.right').val());
        
        parent.find('.total_breaks').val(l+r);
        parent.find('.total_snap').val(snaptotal(l,r));
    }
    
    var snaptotal   =    function(lI, rI)
    {
        return parseFloat(((lI+rI) / 1632) * 100).toFixed(2);
    }
    
    var avgL = function()
    {
        var data =  table.$('.left'), avg = 0, cnt = 0;
        data.each(function(v,e,x)
        {
            var x = parseInt(jQuery(e).val());
            if(x>0)
            {
                cnt++;
                avg+=x;
            }
        });
        
        jQuery(table.column(3).footer()).html(parseFloat(avg/cnt).toFixed(2));
        
    }
    
    var avgLS = function()
    {
        var data =  table.$('.left_snap'), avg = 0, cnt = 0;
        data.each(function(v,e,x)
        {
            var x = parseFloat(jQuery(e).val());
            if(x>0)
            {
                cnt++;
                avg+=x;
            }
        });
        
        jQuery(table.column(4).footer()).html(parseFloat(avg/cnt).toFixed(2));
        
    }
    
    var avgR = function()
    {
        var data =  table.$('.right'), avg = 0, cnt = 0;
        data.each(function(v,e,x)
        {
            var x = parseInt(jQuery(e).val());
            if(x>0)
            {
                cnt++;
                avg+=x;
            }
        });
        
        jQuery(table.column(5).footer()).html(parseFloat(avg/cnt).toFixed(2));
        
    }
    
    var avgRS = function()
    {
        var data =  table.$('.right_snap'), avg = 0, cnt = 0;
        data.each(function(v,e,x)
        {
            var x = parseFloat(jQuery(e).val());
            if(x>0)
            {
                cnt++;
                avg+=x;
            }
        });
        
        jQuery(table.column(6).footer()).html(parseFloat(avg/cnt).toFixed(2));
        
    }
    
    var avgTB = function()
    {
        var data =  table.$('.total_breaks'), avg = 0, cnt = 0;
        data.each(function(v,e,x)
        {
            var x = parseInt(jQuery(e).val());
            if(x>0)
            {
                cnt++;
                avg+=x;
            }
        });
        
        jQuery(table.column(7).footer()).html(parseFloat(avg/cnt).toFixed(2));
        
    }
    
    var avgTS = function()
    {
        var data =  table.$('.total_snap'), avg = 0, cnt = 0;
        data.each(function(v,e,x)
        {
            var x = parseFloat(jQuery(e).val());
            if(x>0)
            {
                cnt++;
                avg+=x;
            }
        });
        
        jQuery(table.column(8).footer()).html(parseFloat(avg/cnt).toFixed(2));
        
    }
    
    var avgRest = function()
    {
        var data =  table.$('.rest:checked');
        var cntRow  = 0;
        var cnt     = 0;
        data.each(function(v,e)
        {
            var par = jQuery(e).parents('tr');
            cnt+=parseFloat(par.find('.total_snap').val());
            cntRow++;
        });
        if(cnt>0 && cntRow>0)
        {
            jQuery('#avgRest').html(parseFloat(cnt/cntRow).toFixed(2));
        }
        else
        {
            jQuery('#avgRest').html('0');
        }
    }
    
    var avgFirstLast = function()
    {
        var data = table.$('.rest'), cntFRow = 0, cntF = 0, cntLRow = 0, cntL = 0, check = false;
        
        data.each(function(v,e)
        {
            if(jQuery(e).is(':checked'))
            {
                check = true;
            }
            else
            {
                var par = jQuery(e).parents('tr');
                if(check)
                {
                    cntL+=parseFloat(par.find('.total_snap').val());
                    cntLRow++;
                }
                else
                {
                    cntF+=parseFloat(par.find('.total_snap').val());
                    cntFRow++;
                }
            }
        });
        
        if(cntF>0 && cntFRow>0)
        {
            jQuery('#avgFirst').html(parseFloat(cntF/cntFRow).toFixed(2));
        }
        else
        {
            jQuery('#avgFirst').html('0');
        }
        
        if(cntL>0 && cntLRow>0)
        {
            jQuery('#avgLast').html(parseFloat(cntL/cntLRow).toFixed(2));
        }
        else
        {
            jQuery('#avgLast').html('0');
        }
    }
    
    var formDetail = function(data)
    {
        
        table.row.add([
            '<a class="btn del"><i class="iconfa-minus-sign"></i></a>',
            '<div class="input-append bootstrap-timepicker"><input type="text" name="waktu[]" id="waktu'+i+'" class="input-large waktu"><span class="add-on"><i class="iconfa-time"></i></span></div>',
            '<input type="checkbox" name="rest[]" value="'+i+'" id="rest'+i+'" class="input-small rest">',
            '<input type="text" name="left[]" id="left'+i+'" class="input-small left">',
            '<input type="text" name="left_snap[]" id="left_snap'+i+'" class="input-small left_snap" readonly="readonly">',
            '<input type="text" name="right[]" id="right'+i+'" class="input-small right">',
            '<input type="text" name="right_snap[]" id="right_snap'+i+'" class="input-small right_snap" readonly="readonly">',
            '<input type="text" name="total_breaks[]" id="total_breaks'+i+'" class="input-small total_breaks" readonly="readonly">',
            '<input type="text" name="total_snap[]" id="total_snap'+i+'" class="input-small total_snap" readonly="readonly">',
            '<input type="text" name="rr_pos[]" id="rr_pos'+i+'" class="input-small rr_pos">',
            '<input type="text" name="speed[]" id="speed'+i+'" class="input-small speed">'
        ]).draw(false);
        i++;
        jQuery('.waktu').timepicker({
            defaultTime: false,
            showMeridian:false
        });
    }
</script>