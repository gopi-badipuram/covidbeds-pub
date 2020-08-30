$(document).ready(function() {

    if(screen.width <= 600) {
        
        var $els = $('.test_center_row'); 
        var $window = $(window);
        
        $window.on('scroll', function(){
            hide = false;
            $els.each(function(){ 
                var $this = $(this); 
                
                var viewport = {
                    top : $window.scrollTop(),
                    left : $window.scrollLeft()
                };
                viewport.right = viewport.left + $window.width();
                viewport.bottom = viewport.top + $window.height();

                var bounds = $this.offset();
                
                bounds.right = bounds.left + $this.outerWidth();
                bounds.bottom = bounds.top + $this.outerHeight();
                
                if (!hide && bounds.top > viewport.top + 150 && bounds.bottom < viewport.bottom) {
                    $this.find('.test_center_details_mobile').show();
                    hide = true;
                } else {
                    $this.find('.test_center_details_mobile').hide();
                }
            });
    
        });
        
    }
});
