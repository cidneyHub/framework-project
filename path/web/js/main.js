$('.checkb').change(function(){

    $('.ajax-item-finished').on({
        click: function(e) {
            e.preventDefault();
            var $href = $(this).attr('href');

            $('<div></div>').load($href+' form', function(){
               //set form
                var $form = $(this).children('form');

                //set checkbox
                var $cbox = $form.find('input[type="checkbox"]');

                //toggle
                $cbox.prop('checked', !$cbox.prop('checked'));

                //form action url
                var $url = $form.attr('action');

                //set data
                var $data = $form.serialize();

                $.ajax({
                    url: $url,
                    data: $data,
                    method: 'post',
                    dataType: 'json',
                    cache: false,
                    success: function(obj){
                        var $tic = $('#item-finished-'+obj.id+' .ajax-item-finished');
                        if(obj.complete){
                            $tic.text('X');
                        }
                        else{
                            $tic.text('O');
                        }
                    },
                    complete: function(){
                        console.log('complete');
                    },
                    error: function(err){
                        console.log('err');
                    }
                });
            });
        }
    })
});