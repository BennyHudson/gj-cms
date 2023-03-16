<?php

    /* 
     * Change WordPress default gallery output
     * http://wpsites.org/?p=10510/
     */

    add_filter('post_gallery', 'ct_post_gallery', 10, 2);
    
    function ct_post_gallery($output, $attr) {

        global $post;
     
        if (isset($attr['orderby'])) {
            $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
            if (!$attr['orderby'])
                unset($attr['orderby']);
        }
     
        extract(shortcode_atts(array(
            'order' => 'ASC',
            'orderby' => 'menu_order ID',
            'id' => $post->ID,
            'itemtag' => 'dl',
            'icontag' => 'dt',
            'captiontag' => 'dd',
            'columns' => 3,
            'size' => 'thumbnail',
            'include' => '',
            'exclude' => ''
        ), $attr));
     
        $id = intval($id);
        if ('RAND' == $order) $orderby = 'none';
     
        if (!empty($include)) {
            $include = preg_replace('/[^0-9,]+/', '', $include);
            $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
     
            $attachments = array();
            foreach ($_attachments as $key => $val) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        }
     
        if (empty($attachments)) return '';

        // Build Thumbnails List

        $output .= '<ul class="gallery-thumbs">';

            $count = -1;

            foreach($attachments as $id => $attachment) {

                $count++;
                $img = wp_get_attachment_image_src($id, 'gallery-thumb');

                $output .= '<li><a href="" data-slide-index="'.$count.'">';

                    $output .= '<img src="'.$img[0].'">';

                $output .= '</a></li>';

            }

        $output .= '</ul>';

        // Build Overlay Gallery

        $output .= '<div class="overlay-wrap">';

            $output .= '<div class="overlay-container">';

                $output .= '<div class="overlay-content">';

                    $output .= '<a href="#" class="overlay-close"><i class="fa fa-times"></i></a>';

                    $output .= '<ul class="overlay-gallery">';

                        foreach($attachments as $id => $attachment) {

                            $img = wp_get_attachment_image_src($id, 'large');
                            $output .= '<li>';

                                $output .= '<img src="'.$img[0].'">';

                            $output .= '</li>';

                        }

                    $output .= '</ul>';

                $output .= '</div>';

            $output .= '</div>';

        $output .= '</div>';

        return $output;
        
    }
    
?>
