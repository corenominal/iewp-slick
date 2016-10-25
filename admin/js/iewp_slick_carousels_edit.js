jQuery(document).ready(function($){

    /**
     * Test for carousel
     */
    var endpoint = $( '#iewp-slick-carousel-slides' ).data( 'endpoint' );
    var apikey = $( '#iewp-slick-carousel-slides' ).data( 'apikey' );
    var data = {
        apikey: apikey,
        action: 'get_carousel',
        carousel: $( '#iewp-slick-carousel-slides' ).data( 'carousel' )
    };
    $.ajax({
        url: endpoint,
        type: 'GET',
        dataType: 'json',
        data: data
    })
    .done(function( data ) {
        if( data.error )
        {
            window.location.href = "admin.php?page=iewp_slick_carousels";
        }
        else
        {
            $( '#iewp-slick-carousel-name' ).val( data.carousel.name );
            get_slides();
        }
    })
    .fail(function( data ) {
        console.log( "error" );
    });

    /**
     * Get the slides
     */
    function get_slides()
    {
        var data = {
            apikey: apikey,
            action: 'get_slides',
            carousel: $( '#iewp-slick-carousel-slides' ).data( 'carousel' )
        };
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            data: data
        })
        .done(function( data ) {
            var slides = '';
			if( data.num_rows == 0 )
			{
				slides = '<tr class="no-slides"><td colspan="3">No slides found!</td></tr>';
			}
			else
			{
				$.each(data.slides, function(i, slide)
				{
					slides += '<tr>';
                    slides += '<td><img class="iewp-slick-slide-thumb" src="' + slide.img_url + '"></td>';
	        		slides += '<td>';
                    slides += '<input type="text" class="regular-text iewp-slick-input iewp-slick-img-title" value="' + slide.img_title + '" placeholder="Image description ...">';
                    slides += '<input type="text" class="regular-text iewp-slick-input iewp-slick-img-alt" value="' + slide.img_alt + '" placeholder="Alt text ...">';
                    slides += '<input type="text" class="regular-text iewp-slick-input iewp-slick-link-url" value="' + slide.link_url + '" placeholder="http://...">';
                    slides += '</td>';
					slides += '<td>';
                    slides += '<button class="button iewp-slick-row-down">&darr;</button> ';
                    slides += '<button class="button iewp-slick-row-up">&uarr;</button> ';
                    slides += '<button class="button iewp-slick-edit-slide-button">Edit</button> ';
					slides += '<button class="button iewp-slick-remove-slide-button">Remove</button>';
					slides += '<div class="remove-slide-prompt">';
					slides += '<span>Are you sure?</span>';
					slides += '<button class="button remove-slide-prompt-yes">Yes</button> ';
					slides += '<button class="button remove-slide-prompt-no">No</button>';
					slides += '</div>';
					slides += '</td></tr>';
				});
			}
			$( '#the-list' ).html( slides );
        })
        .fail(function( data ) {
            console.log( "error" );
        });
    }

    /**
	 * Remove slide
	 */
	$( document ).on( 'click', '.iewp-slick-remove-slide-button', function( e )
	{
		e.preventDefault();
        var el = $( this ).next( '.remove-slide-prompt' );
		$( '.remove-slide-prompt' ).not( el ).slideUp();
		$( el ).slideToggle();
	});

    $( document ).on( 'click', '.remove-slide-prompt-no', function( e )
	{
		e.preventDefault();
		$( '.remove-slide-prompt' ).slideUp();
	});

    $( document ).on( 'click', '.remove-slide-prompt-yes', function( e )
	{
		// e.preventDefault();
		// var data = {
		// 	action: 'delete_slide',
		// 	id: $( this ).attr( 'data-id' ),
        //     apikey: apikey
        // };
		// $.ajax(
		// {
		// 	url: endpoint,
		// 	type: 'GET',
		// 	dataType: 'json',
		// 	data: data
		// })
		// .done(function( data )
		// {
        //     console.log( data );
        //     var carousels = '<tr><td colspan="3">Refreshing plugins ...</td></tr>';
		// 	$( '#the-list' ).html( carousels );
		// 	get_slides();
		// })
		// .fail(function()
		// {
		// 	console.log("OH NOES! AJAX error");
		// });
        e.preventDefault();
        var row = $(this).parents("tr:first");
        row.remove();
        $( '#iewp-slick-save-carousel' ).removeAttr( 'disabled' );
        if( $( '#the-list tr' ).length == 0 )
        {
            $( '#the-list' ).html( '<tr class="no-slides"><td colspan="3">No slides found!</td></tr>' );
        }
	});

    /**
     * Adjust order, move slides up and down
     */
    $( document ).on( 'click', '.iewp-slick-row-up', function( e )
	{
        var row = $(this).parents("tr:first");
        row.insertBefore(row.prev());
        //save_order();
        $( '#iewp-slick-save-carousel' ).removeAttr( 'disabled' );
    });

    $( document ).on( 'click', '.iewp-slick-row-down', function( e )
	{
        var row = $(this).parents("tr:first");
        row.insertAfter(row.next());
        //save_order();
        $( '#iewp-slick-save-carousel' ).removeAttr( 'disabled' );
    });

    // function save_order()
    // {
    //     console.log( 'foo' );
    //     $( 'tbody tr' ).each(function( i )
    //     {
    //       console.log( i + ": " + $( this ).data( 'id' ) );
    //     });
    // }

    /**
	 * Edit slide
	 */
	var mediaUploader;
    $( document ).on( 'click', '.iewp-slick-edit-slide-button', function( e )
	{
		e.preventDefault();

        row = $(this).parents("tr:first");

		if ( mediaUploader )
		{
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media.frames.file_frame = wp.media(
		{
			title: 'Choose an image...',
			button: { text: 'Choose image' },
			multiple: false
		});

		mediaUploader.on('select',function()
		{
			attachment = mediaUploader.state().get('selection').first().toJSON();

            row.find('.iewp-slick-slide-thumb').attr('src', attachment.url);

            if( row.find('.iewp-slick-img-title').val().trim() == '' )
            {
                row.find('.iewp-slick-img-title').val( attachment.title );
            }

            if( row.find('.iewp-slick-img-alt').val().trim() == '' )
            {
                row.find('.iewp-slick-img-alt').val( attachment.alt );
            }

            if( row.find('.iewp-slick-link-url').val().trim() == '' )
            {
                row.find('.iewp-slick-link-url').val( attachment.url );
            }

            $( '#iewp-slick-save-carousel' ).removeAttr( 'disabled' );

		});

		mediaUploader.open();

	});

    /**
	 * Add slide
	 */
	var mediaUploader;
    $( document ).on( 'click', '#iewp-slick-add-slide', function( e )
	{
		e.preventDefault();

		if ( mediaUploader )
		{
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media.frames.file_frame = wp.media(
		{
			title: 'Choose an image...',
			button: { text: 'Choose image' },
			multiple: false
		});

		mediaUploader.on('select',function()
		{
			attachment = mediaUploader.state().get('selection').first().toJSON();
            slide  = '<tr>';
            slide += '<td><img class="iewp-slick-slide-thumb" src="' + attachment.url + '"></td>';
            slide += '<td>';
            slide += '<input type="text" class="regular-text iewp-slick-input iewp-slick-img-title" value="' + attachment.title + '" placeholder="Image description ...">';
            slide += '<input type="text" class="regular-text iewp-slick-input iewp-slick-img-alt" value="' + attachment.alt + '" placeholder="Alt text ...">';
            slide += '<input type="text" class="regular-text iewp-slick-input iewp-slick-link-url" value="' + attachment.url + '" placeholder="http://...">';
            slide += '</td>';
            slide += '<td>';
            slide += '<button class="button iewp-slick-row-down">&darr;</button> ';
            slide += '<button class="button iewp-slick-row-up">&uarr;</button> ';
            slide += '<button class="button iewp-slick-edit-slide-button">Edit</button> ';
            slide += '<button class="button iewp-slick-remove-slide-button">Remove</button>';
            slide += '<div class="remove-slide-prompt">';
            slide += '<span>Are you sure?</span>';
            slide += '<button class="button remove-slide-prompt-yes">Yes</button> ';
            slide += '<button class="button remove-slide-prompt-no">No</button>';
            slide += '</div>';
            slide += '</td></tr>';

            if( $( '#the-list tr.no-slides' ).length == 1 )
            {
                $( '#the-list' ).html( slide );
            }
            else
            {
                $( '#the-list' ).append( slide );
            }

            $( '#iewp-slick-save-carousel' ).removeAttr( 'disabled' );

		});

		mediaUploader.open();

	});

    $( document ).on( 'change keyup', '.iewp-slick-input', function()
    {
        $( '#iewp-slick-save-carousel' ).removeAttr( 'disabled' );
    });

    /**
     * Save carousel
    */
    $( document ).on( 'click', '#iewp-slick-save-carousel', function()
    {
        $( this ).attr( 'disabled', 'disabled' );
        $( this ).html( '<span class="iewp_slick_saving"><img src="/wp-includes/images/spinner.gif"> saving ...</span>' );
        $( this ).removeClass( 'button-primary' );
        var name = $( '#iewp-slick-carousel-name' ).val().trim();
        var carousel_id = $( '#iewp-slick-carousel-slides' ).data('carousel');
        var carousel = [];
        $( 'tbody tr' ).each(function( i )
        {
            row = $( this );
            slide = {
                carousel_id: carousel_id,
                order: i,
                img_url: row.find('.iewp-slick-slide-thumb').attr('src'),
                img_alt: row.find('.iewp-slick-img-alt').val(),
                img_title: row.find('.iewp-slick-img-title').val(),
                link_url: row.find('.iewp-slick-link-url').val()
            };
            carousel.push(slide);
        });
        var data = {
            apikey: apikey,
            action: 'save_carousel',
            carousel: carousel,
            name: name,
            carousel_id: carousel_id,
        };
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            data: data
        })
        .done(function( data ) {
            console.log( data );
            $( '#iewp-slick-carousel-name' ).val( data.name );
            $( '#iewp-slick-save-carousel' ).addClass( 'button-primary' );
            $( '#iewp-slick-save-carousel' ).html( 'save-carousel' );
        })
        .fail(function() {
            console.log("error");
        });

    });

});
