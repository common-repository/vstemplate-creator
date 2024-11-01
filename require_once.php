<?php wp_enqueue_script("jquery"); ?>
<?php $plugindir = get_option('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));?>
<?php
add_action( 'wp_enqueue_scripts', 'wpvs_scripts_method' ); // wp_enqueue_scripts action hook to link only on the front-end
function wpvs_scripts_method() {
$plugin_url=plugins_url()."/vstemplate-creator";//updated on 26-07-2013
    wp_enqueue_script(
		'mask-and-preloader',
		$plugin_url. '/js/mask-and-preloader.js',
		array( 'jquery' )
	);
}
?>
<?php
    /**
     * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
     */
    add_action( 'wp_enqueue_scripts', 'wpvs_add_my_stylesheet' );

    /**
     * Enqueue plugin style-file
     */
    function wpvs_add_my_stylesheet() {
        // Respects SSL, Style.css is relative to the current file
		$plugin_url=plugins_url()."/vstemplate-creator";
        wp_register_style( 'wpvs-style', ''.$plugin_url.'/css/vstemplate.css' );//updated on 26-07-2013
        wp_enqueue_style( 'wpvs-style' );
		
    }
	wpvs_add_my_stylesheet();
?>
