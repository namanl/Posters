<?php
    /**
     * SANITIZATION
     */
         
    function eight_sec_sanitize_textarea($input){
        return wp_kses_post( force_balance_tags( $input ) );
    }
    
    function eight_sec_sanitize_url($input){
        return esc_url_raw($input);
    }
    
    function eight_sec_sanitize_checkbox($input){
        if($input == 1){
            return 1;
        }else{
            return '';
        }
    }
    
    function eight_sec_sanitize_page_select($input){
        $eight_sec_page_lists = eight_sec_page_lists();
        if(array_key_exists($input,$eight_sec_page_lists)){
            return $input;
        }else{
            return '';
        }
    }
    
    function eight_sec_sanitize_category_select($input){
        $eight_sec_category_lists = eight_sec_category_lists();
        if(array_key_exists($input,$eight_sec_category_lists)){
            return $input;
        }else{
            return '';
        }
    }

    function eight_sec_radio_sanitize_alignment_logo($input){
        $bg_repeat = array(
            'left' => esc_html__('Left', 'eight-sec'),
            'center' => esc_html__('Center', 'eight-sec'),
            'right' => esc_html__('Right', 'eight-sec'),
        );
        
        if(array_key_exists($input,$bg_repeat)){
            return $input;
        }else{
            return '';
        }
    }

    function eight_sec_sanitize_weblayout($input){
            $bg_repeat = array(
                'fullwidth'   =>  esc_html__('Fullwidth Layout','eight-sec'),
                'boxed'    =>  esc_html__('Boxed Layout','eight-sec')
            );
            
            if(array_key_exists($input,$bg_repeat)){
                return $input;
            }else{
                return '';
            }
        }

    function eight_sec_sanitize_blog_layout($input){
        $bg_repeat = array(
            'blog_image_large' => esc_html__('Blog Image Large', 'eight-sec'),
            'blog_image_medium' => esc_html__('Blog Image Medium', 'eight-sec'),
            'blog_image_alt_medium' => esc_html__('Blog Image Alternate Medium', 'eight-sec'),
        );
        
        if(array_key_exists($input,$bg_repeat)){
            return $input;
        }else{
            return '';
        }
    }

    function eight_sec_sanitize_radio_yes_no($input){
        $option = array(
                        'yes'   =>  esc_html__('Yes','eight-sec'),
                        'no'    =>  esc_html__('No','eight-sec')
                        );
        if(array_key_exists($input, $option)){
            return $input;
        }
        else
            return '';
    }
    function eight_sec_radio_sanitize_enabledisable($input){
        $option = array(
                    'enable' => esc_html__('Enable', 'eight-sec'),
                    'disable' => esc_html__('Disable', 'eight-sec'),
                    );
        if(array_key_exists($input, $option)){
            return $input;
        }
        else
            return '';
    }
    function eight_sec_sanitize_integer($input){
        return intval($input);
    }

    
?>