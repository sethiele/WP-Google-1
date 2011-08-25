<?php
    function wpg1_feed()
    {
        $rss = fetch_feed( 'http://feeds.feedburner.com/goopl' );
        
        if ( is_wp_error( $rss ) )
        {
            if( is_admin() || current_user_can( 'manage_options' ) )
            {
                print '<p>';
                printf( __( '<strong>RSS Error:</strong>: %s'), $rss->get_error_message() );
                print '</p>';
            }
            return;
        }
        
        if( !$rss->get_item_quantity() )
        {
            print '<p>There is nothing happening on goopl.de</p>';
            $rss->__desdtruct();
            unset( $rss );
            return;
        }
        
        print '<ul>'.PHP_EOL;
        
        if( !isset( $items ) )
        {
            $items = 10;
            
            foreach( $rss->get_items(0, $items) as $item )
            {
                $publisher = '';
                $site_link = '';
                $content = '';
                $date = strip_tags( $item->get_date($date_format = 'j. F Y') );
                $link = esc_url( strip_tags( $item->get_link() ) );
                $title = esc_html( strip_tags( $item->get_title() ) );
                
                $content = $item->get_content();
                $content = wp_html_excerpt( $content, 250 ) . ' ...';
                
                print '<li>'.
                		'<a class="rsswidget" href="'. $link .'">'. $title .'</a> '. 
                		'<span class="rss-date">'.$date .'</span>'. 
                		'<div class="rssSummary">'. $content .'</div></li>'.PHP_EOL;
            }
        }
        
        print '</ul>'.PHP_EOL;
        $rss->__destruct();
        unset($rss);
    }
?>