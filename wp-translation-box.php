<?php
/*
 Plugin Name: WP-Translation-Box
 Plugin URI: http://danielpecos.com/projects/wp-translation-box
 Description: Displays a box in the "Add New Post" page that allows you to quickly translate any text from and to different languages.
 Author: Daniel Pecos Martinez
 Version: 1.8
 Author URI: http://danielpecos.com/
 */
if( !class_exists( 'WPTranslationBox' ) ) {

   class WPTranslationBox {

      function WPTranslationBox() {
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
         add_options_page('WP-Translation-Box Options', 'Translation Box', 'manage_options', 'WPTranslationBox', array(&$this, 'displayOptions'));
         add_meta_box( 'wp-translation-box', __( 'Translation Box' ), array( &$this, 'displayMetaBox' ), 'post', 'side', "core");
         add_meta_box( 'wp-translation-box', __( 'Translation Box' ), array( &$this, 'displayMetaBox' ), 'page', 'side', "core");

      }

      function displayMetaBox() {
         include('views/meta-box.php');
      }

      function displayOptions() {
         include('views/options.php');
      }

      function registerSettings() {        
         //register our settings
         register_setting( 'WPTranslationBox-settings-group', 'wptranslation_source_language' );
         register_setting( 'WPTranslationBox-settings-group', 'wptranslation_target_language' );

         if (is_null(get_option("wptranslation_source_language")) || get_option("wptranslation_source_language") == "") {        
            update_option("wptranslation_source_language", "es");
            update_option("wptranslation_target_language", "en");
         }
      }		
   }

   function gtb_filter_plugin_actions($links, $file){
      static $this_plugin;
      if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

      if ($file == $this_plugin){
         $settings_link = '<a href="options-general.php?page=WPTranslationBox">' . __('Settings') . '</a>';
         array_push($links, $settings_link);
      }
      return $links;
   }

   $wpTranslationBox = new WPTranslationBox;
}
