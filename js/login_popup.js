 $(document).ready(function(){
      $('.fancybox').fancybox({
            openEffect : 'elastic',
            openSpeed  : 150,
            closeEffect : 'elastic',
            closeSpeed  : 150,
            afterLoad: function(current, previous) {$('.alert-login,.ca').hide();}
      });
        $('#SubmitLogin_ajax').click(function(){
            $.ajax({
                type: "POST",
                url: log_url,
                data: $('#os_login_form').serialize(),
                dataType: "json",
                success: function( data ) {
                 if(data.hasError){$('.alert-login').html(data.errors).show();}
                 if(data.hasError==false) window.location=log_myaccount_url;
                }
            });
        });
        $('#SubmitCreate').click(function(){
            $.ajax({
                type: "POST",
                url: caurl,
                data: $('#acreate-account_form').serialize(),
                  dataType: "json",
                success: function( data ) { 
                 if(data.hasError){$('.ca').html(data.errors).show();}
                 if(data.hasError==false) {$('#acreate-account_form').submit()};
                }
            });
        });
        $('.alert-login,.ca').click(function(){ $(this).fadeOut('slow'); });
    });