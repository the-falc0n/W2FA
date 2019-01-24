( function( $ ) {
    $( '#pin-input-container' ).on( 'keydown keyup', 'input', function( event ) {
        const form         = $( '#ski-wtfa-auth-form' );
        const pic          = $( '#pin-input-container' );
        const is_keyup     = event.type == 'keyup' ? true : false;
        const is_backspace = ( event.which == 8 || event.which == 46 ) ? true : false;

        if( ! ( event.which >= 48 && event.which <= 57 ) && ! is_backspace ) {
            return false;
        }

        pic.find( 'input' ).removeClass( 'current' );
        if( is_backspace && is_keyup ) {
            const prevInput = pic.find( 'input.filled:last' );
            if( prevInput.length ) {
                prevInput.val('');
                prevInput.addClass( 'current' ).removeClass( 'filled' ).focus();
            }
        } else if( is_keyup && ! is_backspace ) {
            $( this ).addClass( 'filled' );

            const nextInput = pic.find( 'input:not(.filled)' );
            if( nextInput.length ) {
                nextInput.first().addClass( 'current' ).focus();
            } else {
                $( this ).blur();
            }
        }

        if( pic.find( 'input:not(.filled)' ).length === 0 ) {
            form.find( 'button[type="submit"]' ).prop( 'disabled', false );
        } else {
            form.find( 'button[type="submit"]' ).prop( 'disabled', true );
        }
    } );

    $( document ).on( 'submit', '#ski-wtfa-auth-form', function( event ) {
        event.preventDefault();
        var $form = $( this ),
            $form_submit = $form.find( 'button[type="submit"]' ),
            data = {
                action: 'ski_wtfa_verify_pin',
                ski_wtfa_nonce,
                pin: ''
            };

        $( '#pin-input-container input' ).each( function() {
            data.pin += $( this ).val();
        } );

        if( data.pin.length < 6 ) {
            return false;
        }

        $.ajax( {
            url: ajaxurl,
            type: 'post',
            data: data,
            dataType: 'json',
            beforeSend: function() {
                $form_submit.text('Validating...').prop( 'disabled', true );
            },
            success: function( res ) {
                if( res.status ) {
                    window.location.href = admin_url;
                } else {
                    $form_submit.text('Verify').prop( 'disabled', false );
                }
            }
        } );
    } )
} )( jQuery )
