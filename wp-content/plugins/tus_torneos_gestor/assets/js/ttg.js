
jQuery( document ).ready(function() {

    jQuery('select.select2[name=username]').select2({
        placeholder: "Select a state",
        ajax: {
            url: '../wp-json/wp/v2/getusers',
            dataType: 'json',
            delay: 500,
            data: function (params) {
                return {
                    keyword: params.term,
                };
            },
            processResults: function (data, params) {
                return {
                    results: data,
                };
            },
            cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
    });

    jQuery('select.select2[name=campo_resultado]').select2({
        placeholder: "Seleccione campo",
        ajax: {
            url: '../wp-json/wp/v2/getcampos',
            dataType: 'json',
            delay: 500,
            data: function (params) {
                return {
                    keyword: params.term,
                };
            },
            processResults: function (data, params) {
                return {
                    results: data,
                };
            },
            cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
    });
        
        function formatRepo (repo) {
          if (repo.loading) {
            return repo.text;
          }

          if(repo.email){
              var resp = repo.name + ' ' + repo.email;
          }else{
              var resp = repo.name;
          }
        
          var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
              "<div class='select2-result-repository__title'>" + resp + "</div>" +
            "</div>" +
          "</div>";
        
          return markup;
        }
        
        function formatRepoSelection (repo) {
            console.log(repo);
            if(repo.email){
                var resp = repo.email;
                jQuery('#selected_user').text(repo.name+' '+repo.last_name+'-'+repo.email);
                jQuery('#license_user').val(repo.license);
                console.log(repo.license);
            }else{
                var resp = repo.name;
                jQuery('#selected_campo').text(resp);
            }
            jQuery('#handicap_user').val(repo.handicap);
          
          return resp;
        }

    jQuery('.select2-container').click(function(){
        jQuery('#resultado').addClass('hidden');
        jQuery('.well.resultados form select').each(function(){
            jQuery(this).val(0);
        });
        jQuery('.well.resultados form .subtotal1').text(0);
        jQuery('.well.resultados form .subtotal2').text(0);
        jQuery('.well.resultados form .total').text(0);
    })
      

    jQuery(".well.resultados .campo_form select").change(function() {
        var name = jQuery(this).attr('name');
        switch(name){
            case 'resultado1':
            case 'resultado2':
            case 'resultado3':
            case 'resultado4':
            case 'resultado5':
            case 'resultado6':
            case 'resultado7':
            case 'resultado8':
            case 'resultado9':
                var resultado1 = parseInt(jQuery(this).parents('form').find('[name="resultado1"]').val());
                var resultado2 = parseInt(jQuery(this).parents('form').find('[name="resultado2"]').val());
                var resultado3 = parseInt(jQuery(this).parents('form').find('[name="resultado3"]').val());
                var resultado4 = parseInt(jQuery(this).parents('form').find('[name="resultado4"]').val());
                var resultado5 = parseInt(jQuery(this).parents('form').find('[name="resultado5"]').val());
                var resultado6 = parseInt(jQuery(this).parents('form').find('[name="resultado6"]').val());
                var resultado7 = parseInt(jQuery(this).parents('form').find('[name="resultado7"]').val());
                var resultado8 = parseInt(jQuery(this).parents('form').find('[name="resultado8"]').val());
                var resultado9 = parseInt(jQuery(this).parents('form').find('[name="resultado9"]').val());
                var subtotal1 = resultado1+resultado2+resultado3+resultado4+resultado5+resultado6+resultado7+resultado8+resultado9;
                jQuery(this).parents('form').find('.subtotal1').text(subtotal1);
            break;
            case 'resultado10':
            case 'resultado11':
            case 'resultado12':
            case 'resultado13':
            case 'resultado14':
            case 'resultado15':
            case 'resultado16':
            case 'resultado17':
            case 'resultado18':
                var resultado10 = parseInt(jQuery(this).parents('form').find('[name="resultado10"]').val());
                var resultado11 = parseInt(jQuery(this).parents('form').find('[name="resultado11"]').val());
                var resultado12 = parseInt(jQuery(this).parents('form').find('[name="resultado12"]').val());
                var resultado13 = parseInt(jQuery(this).parents('form').find('[name="resultado13"]').val());
                var resultado14 = parseInt(jQuery(this).parents('form').find('[name="resultado14"]').val());
                var resultado15 = parseInt(jQuery(this).parents('form').find('[name="resultado15"]').val());
                var resultado16 = parseInt(jQuery(this).parents('form').find('[name="resultado16"]').val());
                var resultado17 = parseInt(jQuery(this).parents('form').find('[name="resultado17"]').val());
                var resultado18 = parseInt(jQuery(this).parents('form').find('[name="resultado18"]').val());
                var subtotal2 = resultado10+resultado11+resultado12+resultado13+resultado14+resultado15+resultado16+resultado17+resultado18;
                jQuery(this).parents('form').find('.subtotal2').text(subtotal2);
            break;
        }
        var subtotal1 = parseInt(jQuery(this).parents('form').find('.subtotal1').text());
        var subtotal2 = parseInt(jQuery(this).parents('form').find('.subtotal2').text());
        var total = subtotal1 + subtotal2;
        jQuery(this).parents('form').find('.total').text(total);
    });

    jQuery('.well.resultados .borrar').click(function(){
        var r = confirm("Seguro que quiere borrar los resultados");
        if (r == true) {
            jQuery('.well.resultados form select').each(function(){
                jQuery(this).val(0);
            });
            jQuery('.well.resultados form .subtotal1').text(0);
            jQuery('.well.resultados form .subtotal2').text(0);
            jQuery('.well.resultados form .total').text(0);
        } else {
            return false;
        }
    });
      

    jQuery(".well.campos .campo_form select").change(function() {
        var name = jQuery(this).attr('name');
        switch(name){
            case 'par1':
            case 'par2':
            case 'par3':
            case 'par4':
            case 'par5':
            case 'par6':
            case 'par7':
            case 'par8':
            case 'par9':
                var par1 = parseInt(jQuery(this).parents('form').find('[name="par1"]').val());
                var par2 = parseInt(jQuery(this).parents('form').find('[name="par2"]').val());
                var par3 = parseInt(jQuery(this).parents('form').find('[name="par3"]').val());
                var par4 = parseInt(jQuery(this).parents('form').find('[name="par4"]').val());
                var par5 = parseInt(jQuery(this).parents('form').find('[name="par5"]').val());
                var par6 = parseInt(jQuery(this).parents('form').find('[name="par6"]').val());
                var par7 = parseInt(jQuery(this).parents('form').find('[name="par7"]').val());
                var par8 = parseInt(jQuery(this).parents('form').find('[name="par8"]').val());
                var par9 = parseInt(jQuery(this).parents('form').find('[name="par9"]').val());
                var subtotal1 = par1+par2+par3+par4+par5+par6+par7+par8+par9;
                jQuery(this).parents('form').find('.subtotal1').text(subtotal1);
            break;
            case 'par10':
            case 'par11':
            case 'par12':
            case 'par13':
            case 'par14':
            case 'par15':
            case 'par16':
            case 'par17':
            case 'par18':
                var par10 = parseInt(jQuery(this).parents('form').find('[name="par10"]').val());
                var par11 = parseInt(jQuery(this).parents('form').find('[name="par11"]').val());
                var par12 = parseInt(jQuery(this).parents('form').find('[name="par12"]').val());
                var par13 = parseInt(jQuery(this).parents('form').find('[name="par13"]').val());
                var par14 = parseInt(jQuery(this).parents('form').find('[name="par14"]').val());
                var par15 = parseInt(jQuery(this).parents('form').find('[name="par15"]').val());
                var par16 = parseInt(jQuery(this).parents('form').find('[name="par16"]').val());
                var par17 = parseInt(jQuery(this).parents('form').find('[name="par17"]').val());
                var par18 = parseInt(jQuery(this).parents('form').find('[name="par18"]').val());
                var subtotal2 = par10+par11+par12+par13+par14+par15+par16+par17+par18;
                jQuery(this).parents('form').find('.subtotal2').text(subtotal2);
            break;
        }
        var subtotal1 = parseInt(jQuery(this).parents('form').find('.subtotal1').text());
        var subtotal2 = parseInt(jQuery(this).parents('form').find('.subtotal2').text());
        var total = subtotal1 + subtotal2;
        jQuery(this).parents('form').find('.total').text(total);
    });

    jQuery('.well.campos .guardar').click(function(){
        var form = jQuery(this).parents('form');
        var id_camp = form.find('[name="id_camp"]').val();
        var guardar = true;
        form.find('input:not(.id_card)').each(function(){
            if(jQuery(this).val()==0){
                showAlert('No deje datos a 0');
                return false;
            }else{
                if(parseInt(jQuery(this).val())>18){
                    showAlert('No puede haber handicap mayor a 18');
                    return false;
                }
            }
        })

        var cards = {};
        var handicaps = [];

        var i = 0;
        jQuery(this).parents('form').find('input.id_card').each(function(){ i++;
            var id_card = jQuery(this).val();
            if(id_card!=0){
                i = id_card;
            }
            cards[i] = {};
            cards[i]['hole'] = i;
            cards[i]['id_camp'] = id_camp;
            cards[i]['id'] = parseInt(id_card);
            cards[i]['par'] = parseInt(jQuery(this).parents('form').find('[name="par'+i+'"]').val());
            cards[i]['handicap_hole'] = parseInt(jQuery(this).parents('form').find('[name="handicap'+i+'"]').val());
            handicaps[i] = parseInt(jQuery(this).parents('form').find('[name="handicap'+i+'"]').val());
        });
        if(checkDuplicados(handicaps)){
            showAlert('Hay handicaps duplicados. Revise los datos.');
            return false;
        }else{
            var parametros = {
                "id_camp": id_camp,
                "cards" : cards
            };
            jQuery.ajax({
                type:  'post', //método de envio
                data:  parametros,
                url:   '../wp-json/wp/v2/updatecards', //archivo que recibe la peticion
                beforeSend: function () {
                    jQuery('#Loading').modal();
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    jQuery('#Loading').modal('hide');
                    if(response.status){
                        showAlert('Tarjeta guardada con éxito');
                        jQuery('#ModalClose').click(function(){
                            window.location.href = location.href;
                            return false;
                        })
                    }else{
                        showAlert('Ha ocurrido un error. Inténtelo más tarde');
                    }
                }
            });
        }

        var btn_crear = jQuery(this).parents('form').find('.crear');
        btn_crear.addClass('hidden');
        var btn_borrar = jQuery(this).parents('form').find('.borrar');
        btn_borrar.removeClass('hidden');
        var btn_modificar = jQuery(this).parents('form').find('.modificar');
        btn_modificar.removeClass('hidden');
        var btn_circle = jQuery(this).parents('form').find('.btn-circle');
        btn_circle.removeClass('btn-danger').addClass('btn-success');
        var panel_campo = jQuery(this).parents('form').find('.panel-campo');
        panel_campo.removeClass('danger').addClass('success');
        
    });

    jQuery('.well.campos .borrar').click(function(){
        showConfirmDeleteCard("Seguro que quiere borrar la tarjeta","Borrar tarjeta",jQuery(this));
    });

    function checkDuplicados(hoyos) {
        var a = hoyos;
        var counts = [];
        for(var i = 1; i < a.length; i++) {
            if(counts[a[i]] === undefined) {
                counts[a[i]] = 1;
            } else {
                return true;
            }
        }
        return false;
    }

    function showAlert(message){
        jQuery('#ttgModal .modal-body p').text('');
        jQuery('#ttgModal .modal-body p').text(message);
        jQuery('#ttgModal').modal();
    }

    function showConfirmDeleteCard(message,submitBtn,esto){
        jQuery('#ttgModal .modal-body p').text('');
        jQuery('#ttgModal .modal-body p').text(message);
        jQuery('#ModalSubmit').removeClass('hidden');
        jQuery('#ModalSubmit').text('');
        jQuery('#ModalSubmit').text(submitBtn);
        jQuery('#ttgModal').modal();
        jQuery('#ModalSubmit').click(function(){
            var form = esto.parents('form');
            var id_camp = form.find('[name="id_camp"]').val();
            var cards = {};
            var handicaps = [];
            esto.parents('form').find('input.id_card').each(function(){
                var id_card = jQuery(this).val();
                cards[id_card] = {};
                cards[id_card]['id'] = parseInt(id_card);
            });
            var parametros = {
                "id_camp": id_camp,
                "cards" : cards
            };

            jQuery.ajax({
                type:  'post', //método de envio
                data:  parametros,
                url:   '../wp-json/wp/v2/deletecard', //archivo que recibe la peticion
                beforeSend: function () {
                    jQuery('#Loading').modal();
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    jQuery('#Loading').modal('hide');
                    if(response.status){
                        jQuery('#ModalSubmit').addClass('hidden');
                        showAlert('Tarjeta borrada con éxito');

                        var id_camp = esto.parents('form').find('[name="id_camp"]').val();
                        var form = esto.parents('form');
                        form.find('select').each(function(){
                            jQuery(this).prepend('<option value="0">0</option>');
                            jQuery(this).val(0);
                        })
                        form.find('input:not(.id_camp)').each(function(){
                            jQuery(this).val(0);
                        })
                        esto.parents('form').find('.subtotal1').text(0);
                        esto.parents('form').find('.subtotal2').text(0);
                        esto.parents('form').find('.total').text(0);
            
                        var btn_crear = esto.parents('form').find('.crear');
                        btn_crear.removeClass('hidden');
                        var btn_borrar = esto.parents('form').find('.borrar');
                        btn_borrar.addClass('hidden');
                        var btn_modificar = esto.parents('form').find('.modificar');
                        btn_modificar.addClass('hidden');
                        var btn_circle = esto.parents('form').find('.btn-circle');
                        btn_circle.addClass('btn-danger').removeClass('btn-success');
                        var panel_campo = esto.parents('form').find('.panel-campo');
                        panel_campo.addClass('danger').removeClass('success');
            
                        jQuery('#collapse'+id_camp).collapse("hide");
                    }else{
                        showAlert('Ha ocurrido un error. Inténtelo más tarde');
                    }
                }
            });
        })
        jQuery('#ModalClose').click(function(){
            jQuery('#ModalSubmit').addClass('hidden');
            jQuery('#ttgModal').modal('hide');
            return false;
        })
    }

});