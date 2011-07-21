<?php
function wpg1_user_profile_fields($user)
{
    ?>
    
    <h3><?php _e('Google +1 Profile', 'wp1'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="g1profile"><?php _e('URL to Google +1 Profile'); ?></label></th>
        <td>
            <input type="text" name="g1profile" id="g1profile" value="<?php echo esc_attr( get_user_meta( $user->ID, 'g1profile', true ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php printf(__('URL of your Google+ or (normal) Google profile. E.g. %s', 'wp1'), 'https://plus.google.com/u/1/100912127446274756364/posts'); ?></span>
        </td>
        </tr>
    </table>
    
    
    <?php
}

function wpg1_save_user_profile_fields($user_id)
{
    if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
    update_user_meta( $user_id, 'g1profile', $_POST['g1profile'] );
}

?>