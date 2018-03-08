jQuery( document ).ready(function() {
    
    var SELECTORS = {
        FILTERS : '[data-region="product-filter"]',
        LIST : '[data-region="product-list"]'
    };
    
    var ttgProductFilters = function(){
        this.init();
        this.orderByDate();
        this.list.empty();
        this.list.append(this.items);
    };
    
    ttgProductFilters.prototype.list;
    ttgProductFilters.prototype.items;
    ttgProductFilters.prototype.filters;
    ttgProductFilters.prototype.fields;
    
    ttgProductFilters.prototype.init = function() {
        this.filters = jQuery(SELECTORS.FILTERS);
        this.list = jQuery(SELECTORS.LIST);
        this.items = this.list.find('li');
        this.fields = this.filters.find('.form-control');
        this.eventField();
    };
    
    ttgProductFilters.prototype.eventField = function() {
        var that = this;
        this.fields.on('change',this,function(){
           var field = $(this);
           var value = field.val();
           console.log(value);
        });
    }
    
    ttgProductFilters.prototype.orderByDate = function(){
        this.items.sort(function (a,b) {
            var fit_start_time = jQuery(a).data('date-value');
            var fit_end_time = jQuery(b).data('date-value');
            if(new Date(fit_start_time) >= new Date(fit_end_time)){
                return 1;
            }else{
                return -1;
            }
        });
    }
        
    new ttgProductFilters();
    
});


