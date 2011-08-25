<?php
function wpg1_sb_2_options(){
    $options = get_option('wpg1');
    if($_POST['wpg1-sb2-submit'])
    {
        $options['wpg1-sb2-title']       = $_POST['wpg1-sb2-title'];
        $options['wpg1-sb2-user']        = $_POST['wpg1-sb2-user'];
        $options['wpg1-sb2-anker']       = $_POST['wpg1-sb2-anker'];
        $options['wpg1-sb2-ankerimg']    = $_POST['wpg1-sb2-ankerimg'];
        $options['wpg1-sb2-imgsize']     = $_POST['wpg1-sb2-imgsize'];
        $options['wpg1-sb2-txt1']        = $_POST['wpg1-sb2-txt1'];
        $options['wpg1-sb2-txt2']        = $_POST['wpg1-sb2-txt2'];
        update_option('wpg1', $options);
    }
    $userselect[$options['wpg1-sb2-user']] = 'selected';
    $size[$options['wpg1-sb2-imgsize']] = 'selected';
    ?>
    
    <?php if( !$options['wpg1-add-g1-profile-link'] ): ?>
        <strong><?php _e('Please activate the Google Profile option at the plugin option page first.'); ?></strong>
    <?php else: ?>
    
    <p>
        <label for="wpg1-sb2-title"><?php _e('Title', 'wp1'); ?>:</label><br />
        <input type="text" id="wpg1-sb2-title" name="wpg1-sb2-title" value="<?php print $options['wpg1-sb2-title']; ?>" style="width:100%" />
    </p>
    
    <p>
        <label for="wpg1-sb2-user"><?php _e('Choose the Google Profile of which blog user.'); ?></label><br />
        <select id="wpg1-sb2-user" name="wpg1-sb2-user" style="width:100%">
            <option value=""><?php _e('select', 'wp1'); ?></option>
            <?php $guargs = array(
                                    'blog_id' => $GLOBALS['blog_id']
                                );?>
            <?php $bloguser = get_users( $guargs );?>
            <?php foreach($bloguser as $user): ?>
                <?php $hasprofile = ( !esc_attr( get_user_meta( $user->ID, 'g1profile', true ) ) )? ' (<i>'.__('has no profillink').'</i>)' : ''; ?>
                <option value="<?php print $user->ID; ?>" <?php print $userselect[$user->ID]; ?>><?php print $user->user_login.$hasprofile; ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    
    <p>
        <label for="wpg1-sb2-anker"><?php _e('Anker Text for the link', 'wp1'); ?></label><br />
        <input type="text" id="wpg1-sb2-anker" name="wpg1-sb2-anker" value="<?php print $options['wpg1-sb2-anker']; ?>" style="width:100%" /><br />
        <input type="checkbox" id="wpg1-sb2-ankerimg" name="wpg1-sb2-ankerimg" value="checked" <?php print $options['wpg1-sb2-ankerimg']; ?> /> <?php _e('Use the google icon'); ?>: <img src="http://www.google.com/images/icons/ui/gprofile_button-16.png" width="16" height="16"><br />
        <select id="wpg1-sb2-imgsize" name="wpg1-sb2-imgsize">
            <option value="16" <?php print $size['16']; ?>>16px</option>
            <option value="32" <?php print $size['32']; ?>>32px</option>
            <option value="44" <?php print $size['44']; ?>>44px</option>
            <option value="64" <?php print $size['64']; ?>>64px</option>
        </select> <?php _e('Image size', 'wp1'); ?>
    </p>
    
    <p>
        <label for="wpg1-sb2-txt1"><?php _e('Text above the link.', 'wp1'); ?></label>
        <textarea id="wpg1-sb2-txt1" name="wpg1-sb2-txt1" style="width:100%"><?php print stripslashes( $options['wpg1-sb2-txt1'] ); ?></textarea>
    </p>
    <p>
        <label for="wpg1-sb2-txt2"><?php _e('Text under the link.', 'wp1'); ?></label>
        <textarea id="wpg1-sb2-txt2" name="wpg1-sb2-txt2" style="width:100%"><?php print stripslashes( $options['wpg1-sb2-txt2'] ); ?></textarea>
    </p>
    
    
    
    <input type="hidden" id="wpg1-sb2-submit" name="wpg1-sb2-submit" value="submit" />
    <?php endif; ?>
<?php
}

// TODO: Sidebar 2 output
function wpg1_sb_2_display(){
    $options = get_option('wpg1');
    print $before_widget;
    print $before_title;
    print '<h3 class="widget-title">'.$options['wpg1-sb2-title'].'</h3>';
    print $after_title;
    if( isset( $options['wpg1-sb2-txt1'] ) ) 
        print '<div id="wpg1-sb-p2-txt1">'.stripslashes( $options['wpg1-sb2-txt1'] ).'</div>';
    
    if( $options['wpg1-sb2-ankerimg'] )
        $ankerimg = '<img src="http://www.google.com/images/icons/ui/gprofile_button-'.$options['wpg1-sb2-imgsize'].'.png" width="'.$options['wpg1-sb2-imgsize'].'" height="'.$options['wpg1-sb2-imgsize'].'" id="wpg1-sb-p2-img">';
    else 
        $ankerimg = NULL;
    $ankertxt = '<span id="wpg1-sb-p2-anker">'.$options['wpg1-sb2-anker'].'</span>';
    print wpg1_google_profile_link($options['wpg1-sb2-user'], $ankerimg.' '.$options['wpg1-sb2-anker'], 'self', array('rel' => 'author') );
    
    if( isset( $options['wpg1-sb2-txt2'] ) ) 
        print '<div id="wpg1-sb-p2-txt2">'.stripslashes( $options['wpg1-sb2-txt2'] ).'</div>';
    print $after_widget;
}


?>