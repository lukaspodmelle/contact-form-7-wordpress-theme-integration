<?php

// Default Contact Form 7 form content to be used after install

function cf7_default_content( $template, $prop = 'form' ) {
    if ( 'form' == $prop ) {
        return implode( '', array(

            '<div class="form-fields">',
                '[text* your-name placeholder"Name"]',
                '[email* your-email placeholder"Email"]',
                '[textarea* your-message x3 placeholder"Your message"]',
            '</div>',
            '<div class="form-policy">',
                '[acceptance priv-policy default:on] Agree to Privacy Policy[/acceptance]',
            '</div>',
            '<div class="form-submit">',
                '[submit "Submit"]',
            '</div>'

        ));
    } else {
        return $template;
    } 
}
add_filter(
    'wpcf7_default_template',
    'cf7_default_content',
    10,
    2
);

// Change the title of the automatically created form

function cf7_change_name( $template ) {
    $template->set_title( 'Contact us' ); // edit your form title here
    return $template;
}
add_filter(
    'wpcf7_contact_form_default_pack',
    'cf7_change_name'
);

// Contact Form shortcode on frontend if CF7 plugin is enabled

function cf7_contact_form() {

    if ( in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { // check for plugin installation

      echo do_shortcode( 'contact_form', '[contact-form-7 title="Contact us"]' ); // edit your form title here

    } else { // show message when CF7 not installed

      echo

      '<div class="msg msg-info">
          Please install and activate the Contact Form 7 Plugin to get a&nbsp;form to appear. You can get it <a href="https://wordpress.org/plugins/contact-form-7/">here</a>.
      </div>';

    }
}

?>
