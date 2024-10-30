<?php
/*
Plugin Name: ToneDen Shortcode
Plugin URI: http://wordpress.org/extend/plugins/lasso/
Description: Enables shortcode to embed ToneDen's widget in WordPress blogs.
Version: 1.0
Author: ToneDen, Inc.
Author URI: https://www.toneden.io
License: GPLv2
*/

add_shortcode("toneden", "toneden_shortcode");

/**
 * ToneDen shortcode handler
 * @param {string|array} $atts The attributes passed to the shortcode like [tonedenplayer attr1="value" /].
 * @return {string} HTML code to output.
 */
function toneden_shortcode($atts) {
    $atts = shortcode_atts(array(
        'debug' => 'false', // Output debug messages?
        'user_id' => ''
    ), $atts);

    extract($atts);

    if(!$user_id) {
        return '';
    }

    // Clean inputs and convert them to valid values.
    $debug = lasso_booleanize_string($debug);
    $user_id = lasso_numberize_string($user_id, 10);

    $loaderUrl = '//sd.toneden.io/production/lasso.loader.js';

    $embed = sprintf('<script type="text/javascript">(function() {var script = document.createElement("script");script.type = "text/javascript";script.async = true;script.src = "%s";var entry = document.getElementsByTagName("script")[0];entry.parentNode.insertBefore(script, entry);}());LassoReady = window.LassoReady || [];LassoReady.push(function() {Lasso.configure({debug:%s,user_id:%s});});</script>',
        $loaderUrl, $debug, $user_id);

    return $embed;
}

/**
 * Converts strings into Boolean strings, either 'true' or 'false'.
 */
function lasso_booleanize_string($value) {
    if($value === 'true') {
        return 'true';
    } else {
        return 'false';
    }
}

/**
 * Converts strings into numerical strings. If they cannot be converted, returns default.
 */
function lasso_numberize_string($value, $default = 0) {
    if(is_numeric($value)) {
        return $value;
    } else {
        return $default;
    }
}

?>
