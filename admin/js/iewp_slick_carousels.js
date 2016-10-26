jQuery(document).ready(function($)
{
    /**
	 * List carousel
	 */
    function get_carousels()
    {
        var endpoint = $( '#iewp-slick-carousels' ).data( 'endpoint' );
        var data = {
            apikey: $( '#iewp-slick-carousels' ).data( 'apikey' ),
            action: 'list_carousels'
        };
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            data: data
        })
        .done(function( data ) {
            var carousels = '';
			if( data.num_rows == 0 )
			{
				carousels = '<tr><td colspan="4">No carousels found!</td></tr>';
			}
			else
			{
				$.each(data.carousels, function(i, carousel)
				{
					carousels += '<tr><td>' + carousel.name + '</td>';
	        		carousels += '<td>' + carousel.images + '</td>';
                    carousels += '<td>[iewp-slick-carousel id=' + carousel.id + ']</td>';
					carousels += '<td class="iewp-slick-carousel-options-cell' + carousel.id + '">';
                    carousels += '<button data-id="' + carousel.id + '" class="button iewp-slick-edit-carousel-button">Edit</button> ';
					carousels += '<button data-id="' + carousel.id + '" class="button iewp-slick-remove-carousel-button">Remove</button>';
					carousels += '<div class="remove-carousel-prompt remove-carousel-prompt' + carousel.id + '">';
					carousels += '<span>Are you sure?</span>';
					carousels += '<button data-id="' + carousel.id + '" class="button remove-carousel-prompt-yes">Yes</button> ';
					carousels += '<button data-id="' + carousel.id + '" class="button remove-carousel-prompt-no">No</button>';
					carousels += '</div>';
					carousels += '</td></tr>';
				});
			}
			$( '#the-list' ).html( carousels );
        })
        .fail(function( data ) {
            console.log( "error" );
        });
    }

    get_carousels();

    /**
	 * Edit carousel
	 */
	$( document ).on( 'click', '.iewp-slick-edit-carousel-button', function( e )
	{
		e.preventDefault();
		var id = $( this ).attr( 'data-id' );
        window.location.href = "admin.php?page=iewp_slick_carousels_edit&carousel=" + id;
	});

    /**
	 * Remove carousel from list
	 */
	$( document ).on( 'click', '.iewp-slick-remove-carousel-button', function( e )
	{
		e.preventDefault();
		var id = $( this ).attr( 'data-id' );
		$( '.remove-carousel-prompt' ).not( '.remove-carousel-prompt' + id ).slideUp();
		$( '.remove-carousel-prompt' + id ).slideToggle();
	});

    $( document ).on( 'click', '.remove-carousel-prompt-no', function( e )
	{
		e.preventDefault();
		$( '.remove-carousel-prompt' ).slideUp();
	});

    $( document ).on( 'click', '.remove-carousel-prompt-yes', function( e )
	{
		e.preventDefault();
		var endpoint = $( '#iewp-slick-carousels' ).data( 'endpoint' );
		var data = {
			action: 'delete_carousel',
			id: $( this ).attr( 'data-id' ),
            apikey: $( '#iewp-slick-carousels' ).data( 'apikey' )
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
            console.log( data );
            var carousels = '<tr><td colspan="3">Refreshing plugins ...</td></tr>';
			$( '#the-list' ).html( carousels );
			get_carousels();
		})
		.fail(function()
		{
			console.log("OH NOES! AJAX error");
		});
	});

});
