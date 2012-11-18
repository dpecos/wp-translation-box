<script src="https://www.google.com/jsapi?key=AIzaSyCHN5MMkFj4oGXrLc24XWGRM2XNtjiIYmI"></script>
<script>
google.load("language", "1");

String.prototype.capitalize = function(){ //v1.0
    return this.replace(/\w+/g, function(a){
        return a.charAt(0).toUpperCase() + a.substr(1).toLowerCase();
    });
};

jQuery(document).ready(function() {
    var output = [];
    jQuery.each(google.language.Languages, function(name, code) {
      output.push('<option value="'+ code +'">'+ name.capitalize() +'</option>');
    });
    
    <?php
    $source_lang = get_option("googletranslate_source_language");
    $target_lang = get_option("googletranslate_target_language");
    ?>
    
    jQuery('#source_lang').html(output.join('')).attr("value", "<?php echo $source_lang ?>");
    jQuery('#dest_lang').html(output.join('')).attr("value", "<?php echo $target_lang ?>");
});
</script>

<div class="wrap">
<h2>WP-GoogleTranslate-Box</h2>

<p>These settings will just be preselected when displaying the WP-GoogleTranslate-Box, but you will be able to choose any language there.</p>

<form method="post" action="options.php">
    <?php settings_fields('WPGoogleTranslateBox-settings-group'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Default source language</th>
        <td><select id="source_lang" name="googletranslate_source_language"/></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Default target language</th>
        <td><select id="dest_lang" name="googletranslate_target_language"/></td>
        </tr>
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>