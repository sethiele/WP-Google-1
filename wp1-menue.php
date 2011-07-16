<?php

function wpg1_adminmenue_show()
{
    ?>
    <div class="wrap">
        <h1><?php _e('WP Google +1 option page', 'wpg1'); ?></h1>
        <div id="poststuff">
            <div id="wpg1-option-intheme" class="postbox">
                <h3><input type="checkbox" name="ch_add_to_theme" value="checked" /> Add google +1 button in your theme</h3>
                <div class="inside">
                    <p>
                        To add the google +1 button, please use the following code in your template file.
                    </p>
                    <p style="font-famuly:Consolas, Monaco, 'Courier New', Courier, monospace; font-weight: bold;">
                        &lt;?php if (function_exists('wpg1_g1button')){ print wpg1_g1button('size'); } ?&gt;
                    </p>
                    <p>
                        Please use in stead of <b>size</b> one of the following values.<br />
                        small (15px), medium (20px), standart (24px) and large (60px)
                    </p>
                </div>
            </div>
        </div>
        <div id="wpg1-footer">
            This Plugin ist provided by <a href="http://www.goopl.de">GooPl.de</a> (<g:plusone size="small" href="http://www.goopl.de" count="false"></g:plusone>) and developed by <a href="http://www.sebastian-thiele.net">Sebastian Thiele</a> (<g:plusone size="small" href="http://www.sebastian-thiele.net" count="false"></g:plusone>).
        </div>
    </div>
    
    
    
    <?php
}

?>