<?php

function wpg1_sb_1_options(){
    $options = get_option('wpg1');
    if($_POST['wpg1-sb1-submit'])
    {
        $options['wpg1-sb1-title']      = $_POST['wpg1-sb1-title'];
        $options['wpg1-sb1-size']       = $_POST['wpg1-sb1-size'];
        $options['wpg1-sb1-target']     = $_POST['wpg1-sb1-target'];
        $options['wpg1-sb1-txt1']       = $_POST['wpg1-sb1-txt1'];
        $options['wpg1-sb1-txt2']       = $_POST['wpg1-sb1-txt2'];
        update_option('wpg1', $options);
    }
    if(!$options['wpg1-sb1-size']){
        $options['wpg1-sb1-size'] = 'standard';
    }
    $size[$options['wpg1-sb1-size']] = 'selected';
    $url[$options['wpg1-sb1-target']] = 'selected';
    
    ?>
    <p>
        <label for="wpg1-sb1-title"><?php _e('Title', 'wp1'); ?>:</label><br />
        <input type="text" id="wpg1-sb1-title" name="wpg1-sb1-title" value="<?php print $options['wpg1-sb1-title']; ?>" style="width:100%" />
    </p>
    <p>
        <label for="wpg1-sb1-size"><?php _e('Button size', 'wp1'); ?>:</label><br />
        <select id="wpg1-sb1-size" name="wpg1-sb1-size" style="width:100%">
            <option value="small" <?php print $size['small']; ?>><?php _e('small', 'wp1'); ?></option>
            <option value="medium" <?php print $size['medium']; ?>><?php _e('medium', 'wp1'); ?></option>
            <option value="standard" <?php print $size['standard']; ?>><?php _e('standard', 'wp1'); ?></option>
            <option value="large"  <?php print $size['large']; ?>><?php _e('large', 'wp1'); ?></option>
        </select>
    </p>
    <p>
        <label for="wpg1-sb1-target"><?php _e('Target for the +1 Button', 'wp1'); ?></label>
        <select id="wpg1-sb1-target" name="wpg1-sb1-target" style="width:100%">
            <option value="mainpage" <?php print $url['mainpage']; ?>><?php _e('Blog mainpage', 'wp1'); ?></option>
            <option value="current"  <?php print $url['current']; ?>><?php _e('The shown page', 'wp1'); ?></option>
            <!-- TODO <option value="special"  <?php print $url['special']; ?>><?php _e('A fix given URL', 'wp1'); ?></option> -->
        </select>
    </p>
    <p>
        <label for="wpg1-sb1-txt1"><?php _e('Text above the button.', 'wp1'); ?></label>
        <textarea id="wpg1-sb1-txt1" name="wpg1-sb1-txt1" style="width:100%"><?php print stripslashes( $options['wpg1-sb1-txt1'] ); ?></textarea>
    </p>
    <p>
        <label for="wpg1-sb1-txt2"><?php _e('Text under the button.', 'wp1'); ?></label>
        <textarea id="wpg1-sb1-txt2" name="wpg1-sb1-txt2" style="width:100%"><?php print stripslashes( $options['wpg1-sb1-txt2'] ); ?></textarea>
    </p>
    
    
    <input type="hidden" id="wpg1-sb1-submit" name="wpg1-sb1-submit" value="submit" />
    <?php
}

// Sidebar 1 (g+1 Button) Output
function wpg1_sb_1_display(){
    $options = get_option('wpg1');
    $gplurl = ($options['wpg1-sb1-target'] == 'mainpage')?get_bloginfo('wpurl'):'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    print '<!-- Wordpress Google+ Plugin by - http://www.goopl.de -->';
    print $before_widget;
    print $before_title;
    print '<h3 class="widget-title">'.$options['wpg1-sb1-title'].'</h3>';
    print $after_title;
    if( isset( $options['wpg1-sb1-txt1'] ) ) 
        print '<div id="wpg1-sb-p1-txt1">'.stripslashes( $options['wpg1-sb1-txt1'] ).'</div>';
    print '<div id="wpg1-sb-p1-btn">'.wpg1_g1button($options['wpg1-sb1-size'], $gplurl).'</div>';
    if( isset( $options['wpg1-sb1-txt2'] ) ) 
        print '<div id="wpg1-sb-p1-txt2">'.stripslashes( $options['wpg1-sb1-txt2'] ).'</div>';
    print $after_widget;
    
}

?>