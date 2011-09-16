<?php
function wpg1_sb_3_options(){
    $options = get_option('wpg1');
    if($_POST['wpg1-sb3-submit'])
    {
        $options['wpg1-sb3-title']          = $_POST['wpg1-sb3-title'];
        $options['wpg1-sb3-gid']            = $_POST['wpg1-sb3-gid'];
        $options['wpg1-sb3-reload']         = $_POST['wpg1-sb3-reload'];
        $options['wpg1-sb3-anz']            = $_POST['wpg1-sb3-anz'];
        update_option('wpg1', $options);
    }
    $repeat[$options['pg1-sb3-reload']] = 'selected';
    $anz[$options['wpg1-sb3-anz']] = 'selected';
    ?>
    
    <p>
        <label for="wpg1-sb3-title"><?php _e('Title', 'wp1'); ?>:</label><br />
        <input type="text" id="wpg1-sb3-title" name="wpg1-sb3-title" value="<?php print $options['wpg1-sb3-title']; ?>" style="width:100%" />
    </p>
    
    <p>
        <label for="wpg1-sb3-gid"><?php _e('Show stream for the UserID', 'wp1'); ?>:</label><br />
        <input type="text" id="wpg1-sb3-gid" name="wpg1-sb3-gid" value="<?php print $options['wpg1-sb3-gid']; ?>" style="width:100%" />
    </p>
    
    <p>
        <label for="wpg1-sb3-reload"><?php _e('Reload the stream after', 'wp1'); ?>:</label><br />
        <select id="wpg1-sb3-reload" name="wpg1-sb3-reload">
            <?php for($i = 5; $i <= 60; $i=$i+5): ?>
                <option value="<?php print $i; ?>" <?php print $repeat[$i]; ?>><?php print $i.' '. __('Minutes', 'wp1'); ?></option>
            <?php endfor; ?>
        </select>
    </p>
    
    <p>
        <label for="wpg1-sb3-anz"><?php _e('Number of Entries', 'wp1'); ?>:</label><br />
        <select id="wpg1-sb3-anz" name="wpg1-sb3-anz">
            <?php for($i = 1; $i <= 20; $i++): ?>
                <option value="<?php print $i; ?>" <?php print $anz[$i]; ?>><?php print $i; ?></option>
            <?php endfor; ?>
        </select>
    </p>
    
    <p>
        <label for="wpg1-stream-lastupdate"><?php _e('Last update', 'wp1'); ?>:</label><br />
        <?php print date_i18n('d.m.Y H:i', $options['wpg1-stream-lastupdate']); ?>
    </p>
    
    <input type="hidden" id="wpg1-sb3-submit" name="wpg1-sb3-submit" value="submit" />
    <?php
}

function wpg1_sb_3_display(){
    $options = get_option('wpg1');
    print $before_widget;
    print $before_title;
    print '<h3 class="widget-title">'.$options['wpg1-sb3-title'].'</h3>';
    print $after_title;
    
    if( !$options['wpg1-sb3-gid'] ) 
    {
        print __('<b>Error:</b> No Google Plus UserId', 'wp1');
    }
    else {
        if( $options['wpg1-stream-lastupdate']+60*$options['wpg1-sb3-reload'] < time() ) 
        {
           print 'aktualisiert';
            $options['wpg1-stream-lastupdate'] = time();
            $googlejson = json_decode(file_get_contents('https://www.googleapis.com/plus/v1/people/'.$options['wpg1-sb3-gid'].'/activities/public?alt=json&maxResults='.$options['wpg1-sb3-anz'].'&pageToken=1&pp=1&key=AIzaSyBplZkLayLfEY556fgQNWtfB3n5-gDWqfk'));
            $values = array();
            foreach ($googlejson->items as $itemcount => $item)
            {   
                if (isset($item->object->attachments))
                foreach($item->object->attachments as $attachment)
                {
                    $userAttachment = NULL;
                    if($attachment->objectType == 'article')
					{
                        $userAttachment = '<a href="'.$attachment->url.' target="_blank" style="font-weight: bold;">'.$attachment->displayName.'</a>';
                        break;
                    }
                    elseif($attachment->objectType == 'photo')
					{
						$userAttachment = '<img src="'.$attachment->image->url.'" />';
                        break;
					}
                    elseif($attachment->objectType == 'video')
                    {
                        $youtubeId = substr($attachment->url, 25, 11);
                        $userAttachment = '<a href="http://www.youtube.com/watch?v='.$youtubeId.' target="_blank" style="font-weight: bold;">'.$attachment->displayName.'</a>';
                        break;
                    }
                    
                }
                $value[$itemcount] = array(
                    'userContent' => $item->object->content,
                    'userAttachment' => $userAttachment,
                    'userPost' => strtotime($item->published),
                    'userPostURL' => $item->url
                );
            }
                
            $options['wpg1-stream'] = stripslashes(json_encode($value));
            //update_option('wpg1', $options);
        }
        
        
        
    }
    print $after_widget;
}


?>