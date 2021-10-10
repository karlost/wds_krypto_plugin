(function( $ ) {

    //star rating keep stars
    $(".star-rating-wrp .star").click( function(){
        //refresh each click
        $(".star-rating-wrp .star").removeClass("active");

        //add class to this item and all previus
        $(this).addClass('active');
        $(this).nextAll().addClass('active');

    });

})(jQuery);