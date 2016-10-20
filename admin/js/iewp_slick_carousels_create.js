jQuery(document).ready(function($){

    $( document ).on( 'submit', '#create-carousel-form', function( e )
	{
		e.preventDefault();

        $( '#create-carousel-notify' ).html('');
        $( '#create-carousel-form #submit' ).attr( 'disabled', 'disabled' );

		var name = $( '#carousel_name' ).val().trim();
        $( '#carousel_name' ).val( name );
        var endpoint = $( '#create-carousel-form' ).data( 'endpoint' );
		var data = {
			action: 'create_carousel',
            apikey: $( '#create-carousel-form' ).data( 'apikey' ),
            name: name
        };
        $.ajax(
		{
			url: endpoint,
			type: 'GET',
			dataType: 'json',
			data: data
		})
		.done(function( data )
		{
            if( data.error)
            {
                $( '#create-carousel-notify' ).html( '<div id="message" class="error notice"><p>Error: ' + data.error + '</p></div>' );
                $( '#create-carousel-form #submit' ).removeAttr( 'disabled' );
            }
            else
            {
                window.location.href = "admin.php?page=iewp_slick_carousels_edit&carousel=" + data.id;
            }
		})
		.fail(function()
		{
			console.log("OH NOES! AJAX error");
		});

	});

});
