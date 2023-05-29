# Contact Form 7 integration in a custom theme
Are you developing a custom WordPress theme and want to integrate a default CF7 form into your template? This will help you out.

### Functionality

- On theme installation a message will be displayed in the location of the form
- After the CF7 plugin is installed, a default form will be created with your contents in it
- The shortcode will be used on frontend to display your form

### How it works (functions.php)

Write HTML for the custom default form created automatically by CF7:

```
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
```

The title of the form is changed to match your new shortcode:

```
function cf7_change_name( $template ) {
    $template->set_title( 'Contact us' ); // edit your form title here
    return $template;
}
add_filter(
    'wpcf7_contact_form_default_pack',
    'cf7_change_name'
);
```

Check whether CF7 plugin is installed and insert the shortcode:

```
function cf7_contact_form() {

    if ( in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { // check for plugin installation

      echo do_shortcode( 'contact_form', '[contact-form-7 title="Contact us"]' ); // edit your form title here

    } else { // show message when CF7 not installed

      echo

      '<div class="msg-info">
          Please install and activate the Contact Form 7 Plugin to get a&nbsp;form to appear. You can get it <a href="https://wordpress.org/plugins/contact-form-7/">here</a>.
      </div>';

    }
}
```

### How it works (frontend.php)

To display your form on the frontend, simply call the shortcode function:

```
<?php cf7_contact_form() // Create contact form ?>
```

### TIP

If you want to use the form in a hardcoded location, you can use [Customization API](https://codex.wordpress.org/Theme_Customization_API) and create a new customizer section, where the user can easily swap the shortcode for their own. In this case, you can modify the last function with ``get_theme_mod``:

```
function cf7_contact_form() {
  $cf7_default_shortcode = get_theme_mod( 'contact_form', '[contact-form-7 title="Contact me"]' ); // default shortcode via customizer
  if ( in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { // check for plugin installation
      echo do_shortcode( $cf7_default_shortcode ); // do shortcode
  } else {
      echo
      '<div class="msg-info">
          Please install and activate the Contact Form 7 Plugin to get a form to appear. You can get it <a href="https://wordpress.org/plugins/contact-form-7/">here</a>.
      </div>';
  }
}
```