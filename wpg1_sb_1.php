<?php

// TODO: Sidebar 1 Menue
function wpg1_sb_1_options(){
    $options = get_option('wpg1');
    if($_POST['wpg1-sb1-submit'])
    {
        $options['wpg1-sb1-title']      = $_POST['wpg1-sb1-title'];
        $options['wpg1-sb1-size']       = $_POST['wpg1-sb1-size'];
        update_option('wpg1', $options);
    }
    if(!$options['wpg1-sb1-size']){
        $options['wpg1-sb1-size'] = 'standard';
    }
    $site[$options['wpg1-sb1-size']] = 'selected';
    
    ?>
    <p>
        <label for="wpg1-sb1-title"><?php _e('Title', 'wp1'); ?>:</label><br />
        <input type="text" id="wpg1-sb1-title" name="wpg1-sb1-title" value="<?php print $options['wpg1-sb1-title']; ?>" />
    </p>
    <p>
        <label for="wpg1-sb1-size"><?php _e('Button size', 'wp1'); ?>:</label><br />
        <select id="wpg1-sb1-size" name="wpg1-sb1-size">
            <option value="small" <?php print $site['small']; ?>><?php _e('small', 'wp1'); ?></option>
            <option value="medium" <?php print $site['medium']; ?>><?php _e('medium', 'wp1'); ?></option>
            <option value="standard" <?php print $site['standard']; ?>><?php _e('standard', 'wp1'); ?></option>
            <option value="large"  <?php print $site['large']; ?>><?php _e('large', 'wp1'); ?></option>
        </select>
    </p>
    
    
    <input type="hidden" id="wpg1-sb1-submit" name="wpg1-sb1-submit" value="submit" />
    <?php
}



?>