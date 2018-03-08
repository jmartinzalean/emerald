jQuery( document ).ready(function() {
    
        var SELECTOR = {
            ROOT : '[data-region="result"]',
            USER : '[data-region="user"]',
            CAMP : '[data-region="camp"]',
            SELECTUSER : 'select.select2[name=username]',
            SELECTCAMP : 'select.select2[name=campo_resultado]',            
            HANDLIST : '.handicap',
            SEARCH : '[data-region="search_button"]',
            SAVE : '[data-region="save_button"]',
            RESULTS : '.resultados',
            POINT : '.puntuar',
            DELETE : '.borrar',
            MODAL : '#Loading',
            TTGMODAL : '#ttgModal',
            HANDICAP : '[data-region="handicap_user"]',
            LICENSE : '[data-region="license_user"]',
            CATEGORY : '[data-region="category"]',
            EGR : '[data-region="id_egr"]',
            RESULT : '[data-region="id_result"]',
            SUBTOTAL1 : '#subtotal1',
            SUBTOTAL2 : '#subtotal2',
            TOTAL : '#total'             
        }

        var ttgResult = function(){
            this.init();
            this.searchEvent();
            this.pointEvent();
            this.saveEvent();
            this.handlistEvent();
        }
        

        ttgResult.prototype.root;
        ttgResult.prototype.user;
        ttgResult.prototype.camp;
        ttgResult.prototype.usersel;
        ttgResult.prototype.campsel;
        ttgResult.prototype.selectuser;
        ttgResult.prototype.selectcamp;        
        ttgResult.prototype.handlist;
        ttgResult.prototype.search;
        ttgResult.prototype.results;
        ttgResult.prototype.save;
        ttgResult.prototype.point;
        ttgResult.prototype.delete;
        ttgResult.prototype.modal;
        ttgResult.prototype.handicap;
        ttgResult.prototype.license;        
        ttgResult.prototype.category;  
        ttgResult.prototype.egr;
        ttgResult.prototype.result;
        ttgResult.prototype.ttgmodal;
        ttgResult.prototype.subtotal1; 
        ttgResult.prototype.subtotal2; 
        ttgResult.prototype.total;         
        ttgResult.prototype.data = {}
        ttgResult.prototype.holes = {}

        ttgResult.prototype.init = function(){
            this.root = jQuery(SELECTOR.ROOT);
            this.user = this.root.find(SELECTOR.USER);
            this.camp = this.root.find(SELECTOR.CAMP);
            this.usersel = this.root.find(SELECTOR.USERSEL);
            this.campsel = this.root.find(SELECTOR.CAMPSEL);
            this.handlist = this.root.find(SELECTOR.HANDLIST);
            this.search = jQuery(SELECTOR.SEARCH);
            this.results = this.root.find(SELECTOR.RESULTS);
            this.selectuser = jQuery(SELECTOR.SELECTUSER);
            this.selectcamp = jQuery(SELECTOR.SELECTCAMP);
            this.save = this.root.find(SELECTOR.SAVE);
            this.point = this.root.find(SELECTOR.POINT);
            this.delete = this.root.find(SELECTOR.DELETE);
            this.modal = jQuery(SELECTOR.MODAL);
            this.ttgmodal = jQuery(SELECTOR.TTGMODAL);            
            this.handicap = this.root.find(SELECTOR.HANDICAP);
            this.license = this.root.find(SELECTOR.LICENSE);            
            this.category = this.root.find(SELECTOR.CATEGORY);
            this.egr = this.root.find(SELECTOR.EGR);
            this.result = this.root.find(SELECTOR.RESULT);
            this.subtotal1 = this.root.find(SELECTOR.SUBTOTAL1);  
            this.subtotal2 = this.root.find(SELECTOR.SUBTOTAL2);  
            this.total = this.root.find(SELECTOR.TOTAL);              
        }
                
        ttgResult.prototype.searchEvent = function(){
            this.search.on('click',this,function(){
                var user=this.selectuser.val();
                var camp=this.selectcamp.val();
                if(!user || !camp){
                    alert('Seleccione Jugador y Campo');
                    return false;
                }else{
                    this.cleanFields();
                    this.user.val(user);
                    this.camp.val(camp);
                    this.cleanData();
                    this.prepareData('id_user',user);
                    this.prepareData('id_event',camp);
                    this.searchAjax();
                }
            }.bind(this));
        }
        
        ttgResult.prototype.pointEvent = function(){
            this.point.on('click',this,function(){
            });
        }

        ttgResult.prototype.handlistEvent = function(){
            this.handlist.children('.form-control').on('change', this, function(){
                this.sumHoles();
            }.bind(this));
        }
        
        
        ttgResult.prototype.saveEvent = function(){
            this.save.on('click',this,function(){
                console.log(this.category.val())
                if(this.validteData()){
                    var that = this;
                    this.cleanData();
                    this.handlist.each(function(){
                        var children = jQuery(this).children('.form-control');
                        that.holes[children.attr('name')]=children.val();
                    });
                    this.prepareData('holes',this.holes);
                    this.prepareData('handicap',this.handicap.val());
                    this.prepareData('category',this.category.val());
                    this.prepareData('user',this.user.val());
                    this.prepareData('camp',this.camp.val());
                    this.prepareData('egr',this.egr.val());
                    this.prepareData('result',this.result.val());
                    this.prepareData('license',this.license.val());
                    this.saveAjax();    
                }
            }.bind(this));
        }
        
        ttgResult.prototype.prepareData = function(name,value){
            this.data[name]=value;
        }
        ttgResult.prototype.cleanData = function(){
            this.data={};
            this.holes={};
        }
        ttgResult.prototype.cleanFields = function(){
            this.user.val('');
            this.camp.val('');
            this.handicap.val('');
            this.category.val(0);
            this.egr.val('');
            this.result.val('');
        }        
        ttgResult.prototype.saveAjax = function(){
            var that = this;
            jQuery.ajax({
                type:  'post', 
                data:  that.data,
                url:   '../wp-json/wp/v2/updateresult', 
                beforeSend: function () {
                    jQuery('#Loading').modal();
                },
                success:  function (response) {
                    that.modal.modal('hide');
                    that.modalMsn(response.codigo);
                    that.cleanFields();
                    that.cleanData();
                    that.root.addClass('hidden');
                }
            });
        }
        
        ttgResult.prototype.searchAjax = function(){
            var that = this;
            jQuery.ajax({
                type:  'post', 
                data:  that.data,
                url:   '../wp-json/wp/v2/getgamereventresult', 
                beforeSend: function () {
                    that.modal.modal();
                },
                success:  function (response) {
                    that.modal.modal('hide');
                    if(response.msn){
                        that.completeHoles(response);
                        that.modalMsn('Ya existen datos del jugador en este evento.')
                    }else{
                        that.modalMsn('No existen datos del jugador en este evento.')
                    }
                    that.root.removeClass('hidden');
                }
            });
        }
        
        ttgResult.prototype.completeHoles = function(data) {
            this.handlist.each(function(){
                var children = jQuery(this).children('.form-control');
                var name = children.attr('name');
                children.val(data.holes[name]);
            })
            this.sumHoles();
            this.handicap.val(data.handicap);
            this.egr.val(data.id_egr);
            this.result.val(data.id_result);
            var that=this;
            data.categories.forEach(function(e){
                that.category.children('option[value=' + e + ']').attr('selected',true);
            })
            this.license.val(data.license);
        }
        
        ttgResult.prototype.modalMsn = function(message){
            this.ttgmodal.find('.modal-body p').text('');
            this.ttgmodal.find('.modal-body p').text(message);
            this.ttgmodal.modal();
        }
        
        ttgResult.prototype.validteData = function(){
            if(this.handicap.val() == ''){
                this.modalMsn('Debe rellenar el campo handicap')
                return false;
            }else{
                var category = this.category.val();
                if(category==null){
                    category=[]
                }
                if(category.length == 0 || category.length > 2) {
                    this.modalMsn('Debe elegir una/dos categoria');
                    return false;
                }else{
                    return true;
                }
            }
        }
        
        ttgResult.prototype.sumHoles = function() {
            var that = this;
            this.subtotal1.data('value',0);
            this.subtotal2.data('value',0);
            this.total.data('value',0);
            this.handlist.children('.form-control').each(function(){
                var field = jQuery(this);
                if(field.data( "subtotal" )=='subtotal1'){
                    that.subtotal1.data('value',parseInt(that.subtotal1.data('value'))+parseInt(field.val()));
                }else{
                    that.subtotal2.data('value',parseInt(that.subtotal2.data('value'))+parseInt(field.val()));
                }
                that.total.data('value',parseInt(that.total.data('value'))+parseInt(field.val()));
            })
            this.subtotal1.text(that.subtotal1.data('value'));
            this.subtotal2.text(that.subtotal2.data('value'));
            this.total.text(that.total.data('value'));
        }
        
        
        var prueba = new ttgResult();
    }
)

