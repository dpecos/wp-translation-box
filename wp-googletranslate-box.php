<?php
/*
 Plugin Name: WP-GoogleTranslate-Box
 Plugin URI: http://danielpecos.com/projects/wp-googletranslate-box
 Description: Displays a box in the "Add New Post" page that allows you to quickly translate any text from and to different languages.
 Author: Daniel Pecos Martinez
 Version: 1.1
 Author URI: http://danielpecos.com/
 */
if( !class_exists( 'WPGoogleTranslateBox' ) ) {

	class WPGoogleTranslateBox {
		
		function WPGoogleTranslateBox() {
			$this->addActions();
            $this->addFilters();
		}

		function addActions() {
            add_action( 'admin_init', array( &$this, 'registerSettings' ) );
			add_action( 'admin_menu', array( &$this, 'addAdministrativeMenuItems' ) );
		}
        
        function addFilters() {
            add_filter('plugin_action_links', 'gtb_filter_plugin_actions', 10, 2);
        }
                
		function addAdministrativeMenuItems() {
            //add_options_page('WP-GoogleTranslate-Box Options', 'GoogleTranslate', 'edit_posts', 'WPGoogleTranslateBox', array(&$this, 'displayOptions'));
            add_options_page('WP-GoogleTranslate-Box Options', 'GoogleTranslate', 'manage_options', 'WPGoogleTranslateBox', array(&$this, 'displayOptions'));
			add_meta_box( 'wp-translation-box', __( 'Google Translate' ), array( &$this, 'displayMetaBox' ), 'post', 'side', "core");
            add_meta_box( 'wp-translation-box', __( 'Google Translate' ), array( &$this, 'displayMetaBox' ), 'page', 'side', "core");
            
		}

		function displayMetaBox() {
			include('views/meta-box.php');
		}
        
        function displayOptions() {
            include('views/options.php');
        }
        
        function registerSettings() {        
            //register our settings
            register_setting( 'WPGoogleTranslateBox-settings-group', 'googletranslate_source_language' );
            register_setting( 'WPGoogleTranslateBox-settings-group', 'googletranslate_target_language' );
            
             if (is_null(get_option("googletranslate_source_language")) || get_option("googletranslate_source_language") == "") {        
                update_option("googletranslate_source_language", "es");
                update_option("googletranslate_target_language", "en");
            }
        }		
	}
	
    function gtb_filter_plugin_actions($links, $file){
        static $this_plugin;
        if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

        if ($file == $this_plugin){
            $settings_link = '<a href="options-general.php?page=WPGoogleTranslateBox">' . __('Settings') . '</a>';
            array_push($links, $settings_link);
        }
        return $links;
    }
    
	$wpTranslationBox = new WPGoogleTranslateBox;
}
