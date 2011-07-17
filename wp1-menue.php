<?php

function wpg1_adminmenue_show()
{
    ?>
    
    <?php
		if($_POST[wpg1submit]){
			$wpg1Options = array(
			    "wpg1-addtheme"      =>  $_POST['wpg1-addtheme']
            );
            update_option('wpg1', $wpg1Options);
        }
        $wpg1Options = get_option('wpg1');
    ?>
            
    
    
    <form method="post" action="">
	<?php wp_nonce_field('update-options'); ?>
        <div class="wrap">
            <h1><?php _e('WP Google +1 options page', 'wpg1'); ?></h1>
            <div id="poststuff">
                <div id="wpg1-option-intheme" class="postbox">
                    <h3><input type="checkbox" name="wpg1-addtheme" value="checked" <?php print $wpg1Options['wpg1-addtheme']; ?> /> Add Google +1 button in your theme</h3>
                    <?php if($wpg1Options['wpg1-addtheme']): ?>
                    <div class="inside">
                        <p>
                            <?php _e('To add the Google +1 button please use the following code in your template files.', 'wpg1'); ?>
                        </p>
                        <p style="font-famuly:Consolas, Monaco, 'Courier New', Courier, monospace; font-weight: bold;">
                            &lt;?php if (function_exists('wpg1_g1button')){ print wpg1_g1button('size'); } ?&gt;
                        </p>
                        <p>
                            <? _e('Please use instead of <b>size</b> one of the following values.', 'wpg1'); ?><br />
                            small (15px), medium (20px), standard (24px) and large (60px)
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                
                
                <input type="hidden" name="wpg1submit" value="submit" />
    			<input type="hidden" name="action" value="update" />

    			<p class="submit">
    				<input type="submit" class="button-primary" value="<?php _e('Save', 'wpg1');?>" />
    			</p>
                
            </div>
            <div id="wpg1-footer">
                <p>
                    <?php printf(__('This plugin ist provided by %1$s and developed by %2$s.', 'wpg1'), '<a href="http://www.goopl.de">GooPl.de</a> (<g:plusone size="small" href="http://www.goopl.de" count="false"></g:plusone>)', '<a href="http://www.sebastian-thiele.net">Sebastian Thiele</a> (<g:plusone size="small" href="http://www.sebastian-thiele.net" count="false"></g:plusone>)'); ?>
                    <?php printf(__('<a href="%s">You can leave a note about a bug or a feature request on github.</a>', 'wpg1'), 'https://github.com/sethiele/WP-Google-1/issues'); ?>
                </p>
                <p>
                    <?php _e('Support the development', 'wpg1'); ?>
                    <a href="http://flattr.com/thing/345480/WP-Google-1" target="_blank">
                    <img src="http://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0" /></a>
                </p>
            </div>
        </div>
    </form>
    
    
    
    <?php
}

?>