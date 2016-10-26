jQuery(document).ready(function($){

    function update_iewp_slick_shortcode_example()
    {
        var sel = $( '#iewp-slick-carousel-select select' );
        var id = sel.val();
        $( '#iewp-slick-shortcode-example' ).html( id );
    }

    update_iewp_slick_shortcode_example();

    $( document ).on( 'change keyup', '#iewp-slick-carousel-select select', function()
    {
        update_iewp_slick_shortcode_example();
    });

});
