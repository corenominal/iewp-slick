jQuery(document).ready(function($)
{

    function get_carousels()
    {
        var endpoint = $( '#iewp-slick-carousels' ).data( 'endpoint' );
        var data = {
            apikey: $( '#iewp-slick-carousels' ).data( 'apikey' ),
            action: 'get_carousels'
        };
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            data: data
        })
        .done(function( data ) {
            console.log( data );
            console.log( 'foo' );
        })
        .fail(function( data ) {
            console.log( "error" );
        });
    }

    get_carousels();

});
