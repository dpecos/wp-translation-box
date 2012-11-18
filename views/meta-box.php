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
<script src="https://www.google.com/jsapi?key=AIzaSyCHN5MMkFj4oGXrLc24XWGRM2XNtjiIYmI"></script>
<script>
google.load("language", "1");

var is_text_modified = false;

function wptranslationbox_translate() {
    untranslated_text = jQuery('#untranslated_text').val();

    if (untranslated_text != "") {
		google.language.translate(untranslated_text, jQuery('#source_lang').val(), jQuery('#dest_lang').val(), function(result) {
	    	if (!result.error) {
	            jQuery('#translated_text').attr("value", result.translation);
	        } else {
	            alert(result.error.code + ": " + result.error.message);
	        }
	    });
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
    jQuery.each(google.language.Languages, function(name, code) {
      output.push('<option value="'+ code +'">'+ name.capitalize() +'</option>');
    });
    
    <?php
    $source_lang = get_option("googletranslate_source_language");
    $target_lang = get_option("googletranslate_target_language");
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
	<img src="../wp-content/plugins/wp-googletranslate-box/img/switch.png" onclick="javascript:wptranslationbox_switch()" alt="Switch languages" style="vertical-align: middle"/>
	<select id="dest_lang"></select>
	<img src="../wp-content/plugins/wp-googletranslate-box/img/clear.jpg" onclick="javascript:wptranslationbox_clear()" alt="Clear boxes" style="vertical-align: middle; margin-left: 5px"/>
    <input type="button" class="button tagadd" onclick="javascript:wptranslationbox_translate();" value="<?= __('Translate')?>"/>
    <a href="http://danielpecos.com/projects/wp-googletranslate-box">+info</a>
</div>
