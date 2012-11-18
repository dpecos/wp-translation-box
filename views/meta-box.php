<?php 
global $post;
?>
<style>
#untranslated_text {
	margin-bottom: 5px;
} 
#translated_text {
	background-color: #F5F5F5;
	margin-bottom: 5px; 
	color: #888888; 
	font-style: italic
}
</style>
<script src="<?= plugin_dir_url(__FILE__) ?>/msTranslator.php"></script>
<script>
var is_text_modified = false;

function wptranslationbox_translate() {
    untranslated_text = jQuery('#untranslated_text').val();

    if (untranslated_text != "") {
        var url = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate" +
                "?appId=Bearer " + encodeURIComponent(window.mstranslator_accessToken) +
                "&from=" + encodeURIComponent(jQuery('#source_lang').val()) +
                "&to=" + encodeURIComponent(jQuery('#dest_lang').val()) +
                "&text=" + encodeURIComponent(untranslated_text) +
                "&oncomplete=wptranslationbox_translationCallback";

	jQuery.ajax({
		url: url,
		dataType: 'jsonp'
	});
    }
}

function wptranslationbox_translationCallback(response) {
	if (response !== "") {
		jQuery('#translated_text').attr("value", response);
	} else {
		alert("ERROR: Could not get translation");
	}
	is_text_modified = false;
}

function wptranslationbox_switch() {
	tmp = jQuery('#source_lang').val();
	jQuery('#source_lang').attr("value", jQuery('#dest_lang').val());
	jQuery('#dest_lang').attr("value", tmp);
	//wptranslationbox_translate();
}

function wptranslationbox_clear() {
	jQuery('#untranslated_text').attr("value", "");
	jQuery('#translated_text').attr("value", "");
}


String.prototype.capitalize = function(){ //v1.0
    return this.replace(/\w+/g, function(a){
        return a.charAt(0).toUpperCase() + a.substr(1).toLowerCase();
    });
};


jQuery(document).ready(function() {
    var output = [];
    jQuery.each(window.mstranslator_langs, function(code, name) {
      output.push('<option value="'+ code +'">'+ name.capitalize() +'</option>');
    });
    
    <?php
    $source_lang = get_option("wptranslation_source_language");
    $target_lang = get_option("wptranslation_target_language");
    ?>

    jQuery('#source_lang').html(output.join('')).attr("value", "<?php echo $source_lang ?>").css("width", "8em").css("margin-bottom", "5px");
    jQuery('#dest_lang').html(output.join('')).attr("value", "<?php echo $target_lang ?>").css("width", "8em").css("margin-bottom", "5px");

    jQuery('#untranslated_text').focus(function() {
    	jQuery('#untranslated_text').css("background-color", "lightyellow"); 
    }).blur(function() {
    	jQuery('#untranslated_text').css("background-color", "white");
    }).keypress(function(e) {
    	is_text_modified = true;
        if (e.which == 13) {
    		wptranslationbox_translate();
        	e.preventDefault();
        }
    }).focusout(function(e) {
        if (is_text_modified) {
            wptranslationbox_translate();
            e.preventDefault();
        }
    });
  
});

function selectAll (textarea) {
    textarea.focus();
    textarea.select();
}

</script>

<div>
    <label for="untranslated_text">Original:</label><br/>
    <textarea id="untranslated_text" cols="27" rows="2"></textarea>
</div>

<div>
    <label for="translated_text">Translated:</label><br/>
    <textarea id="translated_text" cols="27" rows="2" readonly="true" onClick="selectAll(this);"></textarea>
</div>

<div>
    <select id="source_lang"></select> 
	<img src="../wp-content/plugins/wp-translation-box/img/switch.png" onclick="javascript:wptranslationbox_switch()" alt="Switch languages" style="vertical-align: middle"/>
	<select id="dest_lang"></select>
	<img src="../wp-content/plugins/wp-translation-box/img/clear.jpg" onclick="javascript:wptranslationbox_clear()" alt="Clear boxes" style="vertical-align: middle; margin-left: 5px"/>
    <input type="button" class="button tagadd" onclick="javascript:wptranslationbox_translate();" value="<?= __('Translate')?>"/>
    <a href="http://danielpecos.com/projects/wp-translation-box">+info</a>
</div>
