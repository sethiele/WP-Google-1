<?php

function wpg1_adminmenue_show()
{
    ?>
    
    <?php
		if($_POST[wpg1submit]){
			$wpg1Options = array(
			    "wpg1-add-theme"                =>  $_POST['wpg1-add-theme'],
                "wpg1-add-g1-profile-link"      =>  $_POST['wpg1-add-g1-profile-link']
            );
            update_option('wpg1', $wpg1Options);
        }
        $wpg1Options = get_option('wpg1');
    ?>
            
    
    
    <form method="post" action="">
	<?php wp_nonce_field('update-options'); ?>
        <div class="wrap">
            <h1><?php _e('WP Google +1 options page', 'wp1'); ?></h1>
            <div id="poststuff">
                <div id="wpg1-option-in-theme" class="postbox">
                    <h3><input type="checkbox" name="wpg1-add-theme" value="checked" <?php print $wpg1Options['wpg1-add-theme']; ?> /> <?php _e('Add Google +1 button in your theme', 'wp1'); ?></h3>
                    <?php if($wpg1Options['wpg1-add-theme']): ?>
                    <div class="inside">
                        <p>
                            <?php _e('To add the Google +1 button please use the following code in your template files.', 'wp1'); ?>
                        </p>
                        <pre style="font-famuly:Consolas, Monaco, 'Courier New', Courier, monospace; font-weight: bold;">
&lt;?php 
    if (function_exists('wpg1_g1button')){ 
        print wpg1_g1button('size'); 
    } 
?&gt;
                        </pre>
                        <p>
                            <?php _e('To add this button in your post content. Add the following text in your content.', 'wp1'); ?>
                        </p>
                        <pre style="font-famuly:Consolas, Monaco, 'Courier New', Courier, monospace; font-weight: bold;">
[wpg1-size]
                        </pre>
                        <p>
                            <? _e('Please use instead of <b>size</b> one of the following values.', 'wp1'); ?><br />
                            small (15px), medium (20px), standard (24px) and large (60px)
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                    
                <div id="wpg1-option-add-g1-profile-link" class="postbox">
                    <h3><input type="checkbox" name="wpg1-add-g1-profile-link" value="checked" <?php print $wpg1Options['wpg1-add-g1-profile-link']; ?> /> <?php _e('Give the authors the option to link their author page to their Google profile.', 'wp1'); ?></h3>
                    <?php if($wpg1Options['wpg1-add-g1-profile-link']): ?>
                    <div class="inside">
                        <p>
                            <?php printf(__('This option activates a new profile field. The author can add his Google or Google+ profile URL. The author can add the following theme function to the author profile template file to show a Google friendly author link inkludet the %1$s.', 'wp1'), 'rel="me"'); ?>
                        </p>
                        <pre style="font-famuly:Consolas, Monaco, 'Courier New', Courier, monospace; font-weight: bold;">
&lt;?php
    if (function_exists('wpg1_google_profile_link')){
        print wpg1_google_profile_link('userID', 'anker', 'target');
    }
?&gt;
                        </pre>
                        <p>
                            <?php _e('<strong>userID</strong> - The user id of the user. Get it from $user->ID.'); ?>
                        </p>
                        <p>
                            <?php _e('<strong>anker</strong> - This will be displayed as the ankertext of the link.<br>
                            (optional) default: the user’s display name', 'wp1'); ?>
                        </p>
                        <p>
                            <?php _e('<strong>target</strong> - In what target should the target page open?<br>
                            (optional) default: _self', 'wp1'); ?>
                        </p>
                                                
                        <p>
                            <?php _e("If the user didn't fill out the URL, nothing will be returned.", 'wp1'); ?><br />
                            <a href="http://www.google.com/support/webmasters/bin/answer.py?answer=1229920" target="_blank"><?php printf(__('More information about Google’s authorship', 'wp1')); ?></a>
                        </p>
                        <p>
                            <?php printf(__('We recommend using the %1$s attribute in all links that link to the author profile.'), 'rel="author"'); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                
                
                <input type="hidden" name="wpg1submit" value="submit" />
    			<input type="hidden" name="action" value="update" />

    			<p class="submit">
    				<input type="submit" class="button-primary" value="<?php _e('Save', 'wp1');?>" />
    			</p>
                
            </div>
            <div id="wpg1-footer">
                <p>
                    <?php printf(__('This plugin ist provided by %1$s and developed by %2$s.', 'wp1'), '<a href="http://www.goopl.de">GooPl.de</a> (<g:plusone size="small" href="http://www.goopl.de" count="false"></g:plusone>)', '<a href="http://www.sebastian-thiele.net">Sebastian Thiele</a> (<g:plusone size="small" href="http://www.sebastian-thiele.net" count="false"></g:plusone>)'); ?>
                    <?php printf(__('<a href="%s">You can leave a note about a bug or a feature request on github.</a>', 'wp1'), 'https://github.com/sethiele/WP-Google-1/issues'); ?>
                </p>
                <p>
                    <?php _e('Support the development', 'wp1'); ?>
                    <a href="http://flattr.com/thing/345480/WP-Google-1" target="_blank">
                    <img src="http://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0" /></a>
                </p>
            </div>
        </div>
    </form>
    
    
    
    <?php
}

?>