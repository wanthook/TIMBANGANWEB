<script src="{{ asset('/assets/js/select2.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.bootstrap-datepicker.js') }}"></script>
<script>
    var type = [
        {'id':'ADMIN', 'text':'Admin'},
        {'id':'USER', 'text':'User'}
    ];
    jQuery(document).ready(function()
    {
        jQuery.ajaxSetup({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'}
        });
        
        jQuery('#type').select2(
        {
            placeholder: "Tipe user",
            minimumInputLength: 0,
            data:{results : type}
        });
        
        jQuery('#dokumen_author').select2({
            minimumInputLength: 0,
            ajax: 
            {
                url: "{{ route('user.selectduaauthor') }}",
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
                        url: "{{ route('user.selectduaauthor') }}",
                        dataType: 'json',
                        type: 'post',
                        data: {id: id}
                    }).done(function(data){ callback(data[0]);});
                }
            }
        });
        
    });
</script>