<?php
// http://stackoverflow.com/questions/29134113/how-to-remove-or-dequeue-google-fonts-in-wordpress-twentyfifteen
// give later priority to action, default is 10, 20 will execute after
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 20);
function theme_enqueue_styles() {
  // add parent stylesheet
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  // remove scripts and fonts
  wp_dequeue_script('twentyfifteen-script');
  wp_dequeue_style('twentyfifteen-fonts');
}
