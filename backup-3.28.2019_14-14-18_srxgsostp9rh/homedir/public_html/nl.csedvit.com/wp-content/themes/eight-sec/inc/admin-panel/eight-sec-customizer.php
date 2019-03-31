<?php
	function eight_sec_customizer( $wp_customize ) {
		require get_template_directory() . '/inc/admin-panel/eight-sec-sanitize.php';

		$eight_sec_category_lists 	=	eight_sec_category_lists();

		$wp_customize->add_panel(
			'eight_sec_default_setting',
			array(
				'title' => esc_html__('Default Setting', 'eight-sec'),
				'priority'	=>	1,
				'panel'	=>	'eight_sec_default_setting'
				)
			);
			
			$wp_customize->get_section('title_tagline')->panel = 'eight_sec_default_setting'; //priority 20
			$wp_customize->get_section('colors')->panel = 'eight_sec_default_setting'; //priority 40
			$wp_customize->get_section('header_image')->panel = 'eight_sec_default_setting'; //priority 60
			$wp_customize->get_section('background_image')->panel = 'eight_sec_default_setting'; //priority 80
			$wp_customize->get_section('static_front_page')->panel = 'eight_sec_default_setting'; //priority 120

			$wp_customize->add_section(
		        'eight_sec_default_setting_weblayout',
		        array(
		            'title'         =>  esc_html__('Web Layout','eight-sec'),
		            'priority'      =>  130,
		            'panel'         =>	'eight_sec_default_setting',
		            )
		        );

		        $wp_customize->add_setting(
		            'eight_sec_default_setting_weblayout_layout',
		            array(
		                'default'           =>  'fullwidth',
		                'sanitize_callback' =>  'eight_sec_sanitize_weblayout',
		                )
		            );

		        $wp_customize->add_control(
		            'eight_sec_default_setting_weblayout_layout',
		            array(
		                'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
		                'section'       =>  'eight_sec_default_setting_weblayout',
		                'setting'       =>  'eight_sec_default_setting_weblayout_layout',
		                'priority'      =>  10,
		                'type'          =>  'radio',
		                'choices'        =>  array(
		                    'fullwidth'   =>  esc_html__('Fullwidth Layout','eight-sec'),
		                    'boxed'    =>  esc_html__('Boxed Layout','eight-sec')
		                    )
		                )                   
		            );
		        $wp_customize->add_section(
					'eight_sec_footer_setting_footer_copyright',
					array(
						'title'           =>      esc_html__('Footer Copyright', 'eight-sec'),
						'priority'        =>      '130',
						'panel' => 'eight_sec_default_setting'
						)
					);

					$wp_customize->add_setting(
						'eight_sec_footer_setting_footer_copyright_text',array(
							'default' => '',
							'transport' => 'postMessage',
							'sanitize_callback' => 'sanitize_text_field',
							)
						);

					$wp_customize->add_control(
						'eight_sec_footer_setting_footer_copyright_text',
						array(
							'type' => 'textarea',
							'label' => esc_html__('Footer Copyright Area Text', 'eight-sec'),
							'description' => esc_html__('Enter text or Html to show in the footer.', 'eight-sec'),
							'section' => 'eight_sec_footer_setting_footer_copyright',
							)
						);


	    // Add Hompeage setting Panel
	    $wp_customize->add_panel(
	    'eight_sec_homepage_setting',
	    array(
	        'priority'      => 50,
	        'capability'    =>  'edit_theme_options',
	        'description'   =>  esc_html__('Settings for Homepage Section of the theme','eight-sec'),
	        'theme_supports'=>  '',
	        'title'         =>  esc_html__('Homepage Section','eight-sec'),
	        )
	    );

	    	//Slider section

		    $wp_customize->add_section(
		        'eight_sec_homepage_setting_slider_section',
		        array(
		            'title'         =>  esc_html__('Slider Section','eight-sec'),
		            'description'   =>  esc_html__('Settings of the Slider section','eight-sec'),
		            'priority'      =>  1,
		            'panel'         =>	'eight_sec_homepage_setting',
		            )
		        );

		        $wp_customize->add_setting(
		            'eight_sec_homepage_setting_slider_section_option',
		            array(
		                'default'           =>  'no',
		                'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
		                )
		            );

		        $wp_customize->add_control(
		            'eight_sec_homepage_setting_slider_section_option',
		            array(
		                'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
		                'section'       =>  'eight_sec_homepage_setting_slider_section',
		                'setting'       =>  'eight_sec_homepage_setting_slider_section_option',
		                'priority'      =>  10,
		                'type'          =>  'radio',
		                'choices'        =>  array(
		                    'yes'   =>  esc_html__('Yes','eight-sec'),
		                    'no'    =>  esc_html__('No','eight-sec')
		                    )
		                )                   
		            );
		        
		        $wp_customize->add_setting(
		            'eight_sec_homepage_setting_slider_section_category',
		            array(
		                'default'           =>  '0',
		                'sanitize_callback' =>  'sanitize_text_field',
		                )
		            );

		        $wp_customize->add_control(
		            'eight_sec_homepage_setting_slider_section_category',
		            array(
		                'priority'      =>  30,
		                'label'         =>  esc_html__('Select category','eight-sec'),
		                'section'       =>  'eight_sec_homepage_setting_slider_section',
		                'setting'       =>  'eight_sec_homepage_setting_slider_section_category',
		                'type'          =>  'select',  
		                'choices'       =>  $eight_sec_category_lists
		                )                                     
		            );     

		        $wp_customize->add_setting(
		            'eight_sec_homepage_setting_slider_section_readmore',
		            array(
		                'default'           =>  esc_html__('Get Started','eight-sec'),
		                'sanitize_callback' =>  'sanitize_text_field',
		                )
		            );

		        $wp_customize->add_control(
		            'eight_sec_homepage_setting_slider_section_readmore',
		            array(
		                'priority'      =>  30,
		                'label'         =>  esc_html__('Read more text','eight-sec'),
		                'section'       =>  'eight_sec_homepage_setting_slider_section',
		                'setting'       =>  'eight_sec_homepage_setting_slider_section_readmore',
		                'type'          =>  'text',  
		                )                                     
		            );

		        $wp_customize->add_setting(
		            'eight_sec_homepage_setting_slider_section_control',
		            array(
		                'default'           =>  'no',
		                'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
		                )
		            );

		        $wp_customize->add_control(
		            'eight_sec_homepage_setting_slider_section_control',
		            array(
		                'label'   =>  esc_html__('Show control','eight-sec'),
		                'section'       =>  'eight_sec_homepage_setting_slider_section',
		                'setting'       =>  'eight_sec_homepage_setting_slider_section_control',
		                'priority'      =>  40,
		                'type'          =>  'radio',
		                'choices'        =>  array(
		                    'yes'   =>  esc_html__('Yes','eight-sec'),
		                    'no'    =>  esc_html__('No','eight-sec')
		                    )
		                )                   
		            );

		        $wp_customize->add_setting(
		            'eight_sec_homepage_setting_slider_section_pager',
		            array(
		                'default'           =>  'no',
		                'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
		                )
		            );

		        $wp_customize->add_control(
		            'eight_sec_homepage_setting_slider_section_pager',
		            array(
		                'label'   =>  esc_html__('Show pager','eight-sec'),
		                'section'       =>  'eight_sec_homepage_setting_slider_section',
		                'setting'       =>  'eight_sec_homepage_setting_slider_section_pager',
		                'priority'      =>  50,
		                'type'          =>  'radio',
		                'choices'        =>  array(
		                    'yes'   =>  esc_html__('Yes','eight-sec'),
		                    'no'    =>  esc_html__('No','eight-sec')
		                    )
		                )                   
		            );

	        // About section and thier controls
	        $wp_customize->add_section(
	            'eight_sec_homepage_setting_about_section',
	            array(
	                'title'         =>  esc_html__('About Section','eight-sec'),
	                'description'   =>  esc_html__('Settings of the About Section','eight-sec'),
	                'priority'      =>  20,
	                'panel'         =>  'eight_sec_homepage_setting'        
	                )
	            );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_about_section_option',
	                array(
	                    'default'           =>  'no',
	                    'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_about_section_option',
	                array(
	                    'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_about_section',
	                    'setting'       =>  'eight_sec_homepage_setting_about_section_option',
	                    'priority'      =>  10,
	                    'type'          =>  'radio',
	                    'choices'        =>  array(
	                        'yes'   =>  esc_html__('Yes','eight-sec'),
	                        'no'    =>  esc_html__('No','eight-sec')
	                        )
	                    )                   
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_about_section_menu_title_text',
	                array(
	                    'default'           =>  esc_html__('About us','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_about_section_menu_title_text',
	                array(
	                    'priority'      =>  20,
	                    'label'         =>  esc_html__('Menu title text','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_about_section',
	                    'setting'       =>  'eight_sec_homepage_setting_about_section_menu_title_text',
	                    'type'          =>  'text',  
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_about_section_page',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_integer',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_about_section_page',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select Page','eight-sec'),
	                    'description' => esc_html__('Choose page to display section title and description in about section.','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_about_section',
	                    'setting' =>    'eight_sec_homepage_setting_about_section_page',
	                    'type'    =>    'dropdown-pages',
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_about_section_select',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_category_select',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_about_section_select',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select Category','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_about_section',
	                    'setting' =>    'eight_sec_homepage_setting_about_section_select',
	                    'type'    =>    'select',
	                    'choices' =>    $eight_sec_category_lists,           
	                    )                                     
	                );


	        //Add Portfolio section and their controls

	        $wp_customize->add_section(
	            'eight_sec_homepage_setting_portfolio_section',
	            array(
	                'title'         =>  esc_html__('Portfolio Section','eight-sec'),
	                'description'   =>  esc_html__('Settings of the Portfolio Section','eight-sec'),
	                'priority'      =>  30,
	                'panel'         =>  'eight_sec_homepage_setting'        
	                )
	            );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_portfolio_section_option',
	                array(
	                    'default'           =>  'no',
	                    'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_portfolio_section_option',
	                array(
	                    'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_portfolio_section',
	                    'setting'       =>  'eight_sec_homepage_setting_portfolio_section_option',
	                    'priority'      =>  10,
	                    'type'          =>  'radio',
	                    'choices'        =>  array(
	                        'yes'   =>  esc_html__('Yes','eight-sec'),
	                        'no'    =>  esc_html__('No','eight-sec')
	                        )
	                    )                   
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_portfolio_section_menu_title_text',
	                array(
	                    'default'           =>  esc_html__('Portfolio','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_portfolio_section_menu_title_text',
	                array(
	                    'priority'      =>  20,
	                    'label'         =>  esc_html__('Menu title text','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_portfolio_section',
	                    'setting'       =>  'eight_sec_homepage_setting_portfolio_section_menu_title_text',
	                    'type'          =>  'text',  
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_portfolio_section_page',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_integer',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_portfolio_section_page',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select Page','eight-sec'),
	                    'description' => esc_html__('Choose page to display section title and description in portfolio section.','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_portfolio_section',
	                    'setting' =>    'eight_sec_homepage_setting_portfolio_section_page',
	                    'type'    =>    'dropdown-pages',
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_portfolio_section_select',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_category_select',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_portfolio_section_select',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select category','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_portfolio_section',
	                    'setting' =>    'eight_sec_homepage_setting_portfolio_section_select',
	                    'type'    =>    'select',
	                    'choices' =>    $eight_sec_category_lists,           
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_portfolio_section_viewall',
	                array(
	                    'default'           =>  esc_html__('View all','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_portfolio_section_viewall',
	                array(
	                    'priority'=>    45,
	                    'label'   =>    esc_html__('View all','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_portfolio_section',
	                    'setting' =>    'eight_sec_homepage_setting_portfolio_section_viewall',
	                    'type'    =>    'text',
	                    )                                     
	                );

	            

	        

	        //Add Blog section and their controls

	        $wp_customize->add_section(
	            'eight_sec_homepage_setting_blog_section',
	            array(
	                'title'         =>  esc_html__('Blog Section','eight-sec'),
	                'description'   =>  esc_html__('Settings of the Blog Section','eight-sec'),
	                'priority'      =>  60,
	                'panel'         =>  'eight_sec_homepage_setting'        
	                )
	            );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_blog_section_option',
	                array(
	                    'default'           =>  'no',
	                    'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_blog_section_option',
	                array(
	                    'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_blog_section',
	                    'setting'       =>  'eight_sec_homepage_setting_blog_section_option',
	                    'priority'      =>  10,
	                    'type'          =>  'radio',
	                    'choices'        =>  array(
	                        'yes'   =>  esc_html__('Yes','eight-sec'),
	                        'no'    =>  esc_html__('No','eight-sec')
	                        )
	                    )                   
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_blog_section_menu_title_text',
	                array(
	                    'default'           =>  esc_html__('Blog','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_blog_section_menu_title_text',
	                array(
	                    'priority'      =>  20,
	                    'label'         =>  esc_html__('Menu title text','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_blog_section',
	                    'setting'       =>  'eight_sec_homepage_setting_blog_section_menu_title_text',
	                    'type'          =>  'text',  
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_blog_section_page',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_integer',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_blog_section_page',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select Page','eight-sec'),
	                    'description' => esc_html__('Choose page to display section title and description in blog section.','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_blog_section',
	                    'setting' =>    'eight_sec_homepage_setting_blog_section_page',
	                    'type'    =>    'dropdown-pages',
	                    )                                     
	                );


	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_blog_section_select',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_category_select',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_blog_section_select',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select category','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_blog_section',
	                    'setting' =>    'eight_sec_homepage_setting_blog_section_select',
	                    'type'    =>    'select',
	                    'choices' =>    $eight_sec_category_lists,           
	                    )                                     
	                );	            


	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_blog_section_viewall',
	                array(
	                    'default'           =>  esc_html__('View all','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_blog_section_viewall',
	                array(
	                    'priority'=>    45,
	                    'label'   =>    esc_html__('View all blogs','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_blog_section',
	                    'setting' =>    'eight_sec_homepage_setting_blog_section_viewall',
	                    'type'    =>    'text',
	                    )                                     
	                );

	            

	        // Call to Action Section and their configuations

	        $wp_customize->add_section(
	            'eight_sec_homepage_setting_cta_section',
	            array(
	                'title'         =>  esc_html__('Call to Action Section','eight-sec'),
	                'description'   =>  esc_html__('Settings of the Call to Action(CTA) Section','eight-sec'),
	                'priority'      =>  50,
	                'panel'         =>  'eight_sec_homepage_setting'        
	                )
	            );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_cta_section_option',
	                array(
	                    'default'           =>  'no',
	                    'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_cta_section_option',
	                array(
	                    'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_cta_section',
	                    'setting'       =>  'eight_sec_homepage_setting_cta_section_option',
	                    'priority'      =>  10,
	                    'type'          =>  'radio',
	                    'choices'        =>  array(
	                        'yes'   =>  esc_html__('Yes','eight-sec'),
	                        'no'    =>  esc_html__('No','eight-sec')
	                        )
	                    )                   
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_cta_section_menu_title_text',
	                array(
	                    'default'           =>  esc_html__('CTA','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_cta_section_menu_title_text',
	                array(
	                    'priority'      =>  20,
	                    'label'         =>  esc_html__('Menu title text','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_cta_section',
	                    'setting'       =>  'eight_sec_homepage_setting_cta_section_menu_title_text',
	                    'type'          =>  'text',  
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_cta_section_page',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_integer',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_cta_section_page',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select Page','eight-sec'),
	                    'description' => esc_html__('Choose page to display section title and description in cta section.','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_cta_section',
	                    'setting' =>    'eight_sec_homepage_setting_cta_section_page',
	                    'type'    =>    'dropdown-pages',
	                    )                                     
	                );

	            
	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_cta_section_button_text',
	                array(
	                    'default'           =>  esc_html__('Hire us','eight-sec'),
	                    'sanitize_callback' =>  'eight_sec_sanitize_textarea',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_cta_section_button_text',
	                array(
	                    'priority'      =>  40,
	                    'label'         =>  esc_html__('Button text','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_cta_section',
	                    'setting'       =>  'eight_sec_homepage_setting_cta_section_button_text',
	                    'type'          =>  'text',  
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_cta_section_button_link',
	                array(
	                    'default'           =>  '#',
	                    'sanitize_callback' =>  'eight_sec_sanitize_textarea',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_cta_section_button_link',
	                array(
	                    'priority'      =>  40,
	                    'label'         =>  esc_html__('Button link','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_cta_section',
	                    'setting'       =>  'eight_sec_homepage_setting_cta_section_button_link',
	                    'type'          =>  'text',  
	                    )                                     
	                );


	            

	        //Add Team section and their controls

	        $wp_customize->add_section(
	            'eight_sec_homepage_setting_team_section',
	            array(
	                'title'         =>  esc_html__('Team Section','eight-sec'),
	                'description'   =>  esc_html__('Settings of the Team Section','eight-sec'),
	                'priority'      =>  30,
	                'panel'         =>  'eight_sec_homepage_setting'        
	                )
	            );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_team_section_option',
	                array(
	                    'default'           =>  'no',
	                    'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_team_section_option',
	                array(
	                    'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_team_section',
	                    'setting'       =>  'eight_sec_homepage_setting_team_section_option',
	                    'priority'      =>  10,
	                    'type'          =>  'radio',
	                    'choices'        =>  array(
	                        'yes'   =>  esc_html__('Yes','eight-sec'),
	                        'no'    =>  esc_html__('No','eight-sec')
	                        )
	                    )                   
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_team_section_menu_title_text',
	                array(
	                    'default'           =>  esc_html__('Team','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_team_section_menu_title_text',
	                array(
	                    'priority'      =>  20,
	                    'label'         =>  esc_html__('Menu title text','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_team_section',
	                    'setting'       =>  'eight_sec_homepage_setting_team_section_menu_title_text',
	                    'type'          =>  'text',  
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_team_section_page',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_integer',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_team_section_page',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select Page','eight-sec'),
	                    'description' => esc_html__('Choose page to display section title and description in team section.','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_team_section',
	                    'setting' =>    'eight_sec_homepage_setting_team_section_page',
	                    'type'    =>    'dropdown-pages',
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_team_section_select',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_category_select',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_team_section_select',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select category','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_team_section',
	                    'setting' =>    'eight_sec_homepage_setting_team_section_select',
	                    'type'    =>    'select',
	                    'choices' =>    $eight_sec_category_lists,           
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_team_section_viewall',
	                array(
	                    'default'           =>  esc_html__('View all','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_team_section_viewall',
	                array(
	                    'priority'=>    45,
	                    'label'   =>    esc_html__('View all team','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_team_section',
	                    'setting' =>    'eight_sec_homepage_setting_team_section_viewall',
	                    'type'    =>    'text',
	                    )                                     
	                );
	            
	            
	        //Add Testimonial section and their controls

	        $wp_customize->add_section(
	            'eight_sec_homepage_setting_testimonial_section',
	            array(
	                'title'         =>  esc_html__('Testimonial Section','eight-sec'),
	                'description'   =>  esc_html__('Settings of the Testimonial Section','eight-sec'),
	                'priority'      =>  70,
	                'panel'         =>  'eight_sec_homepage_setting'        
	                )
	            );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_testimonial_section_option',
	                array(
	                    'default'           =>  'no',
	                    'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_testimonial_section_option',
	                array(
	                    'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_testimonial_section',
	                    'setting'       =>  'eight_sec_homepage_setting_testimonial_section_option',
	                    'priority'      =>  10,
	                    'type'          =>  'radio',
	                    'choices'        =>  array(
	                        'yes'   =>  esc_html__('Yes','eight-sec'),
	                        'no'    =>  esc_html__('No','eight-sec')
	                        )
	                    )                   
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_testimonial_section_menu_title_text',
	                array(
	                    'default'           =>  esc_html__('Testimonial','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_testimonial_section_menu_title_text',
	                array(
	                    'priority'      =>  20,
	                    'label'         =>  esc_html__('Menu title text','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_testimonial_section',
	                    'setting'       =>  'eight_sec_homepage_setting_testimonial_section_menu_title_text',
	                    'type'          =>  'text',  
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_testimonial_section_page',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_integer',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_testimonial_section_page',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select Page','eight-sec'),
	                    'description' => esc_html__('Choose page to display section title and description in testimonial section.','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_testimonial_section',
	                    'setting' =>    'eight_sec_homepage_setting_testimonial_section_page',
	                    'type'    =>    'dropdown-pages',
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_testimonial_section_select',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_category_select',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_testimonial_section_select',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select category','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_testimonial_section',
	                    'setting' =>    'eight_sec_homepage_setting_testimonial_section_select',
	                    'type'    =>    'select',
	                    'choices' =>    $eight_sec_category_lists,           
	                    )                                     
	                );

	            
	            

	        //Add Contact section and their controls

	        $wp_customize->add_section(
	            'eight_sec_homepage_setting_contact_section',
	            array(
	                'title'         =>  esc_html__('Contact Section','eight-sec'),
	                'description'   =>  esc_html__('Settings of the Contact Section','eight-sec'),
	                'priority'      =>  80,
	                'panel'         =>  'eight_sec_homepage_setting'        
	                )
	            );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_contact_section_option',
	                array(
	                    'default'           =>  'no',
	                    'sanitize_callback' =>  'eight_sec_sanitize_radio_yes_no',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_contact_section_option',
	                array(
	                    'description'   =>  esc_html__('Do you want to enable this section?','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_contact_section',
	                    'setting'       =>  'eight_sec_homepage_setting_contact_section_option',
	                    'priority'      =>  1,
	                    'type'          =>  'radio',
	                    'choices'        =>  array(
	                        'yes'   =>  esc_html__('Yes','eight-sec'),
	                        'no'    =>  esc_html__('No','eight-sec')
	                        )
	                    )                   
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_contact_section_menu_title_text',
	                array(
	                    'default'           =>  esc_html__('Contact us','eight-sec'),
	                    'sanitize_callback' =>  'sanitize_text_field',
	                    'transport'			=>	'postMessage',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_contact_section_menu_title_text',
	                array(
	                    'priority'      =>  10,
	                    'label'         =>  esc_html__('Menu title text','eight-sec'),
	                    'section'       =>  'eight_sec_homepage_setting_contact_section',
	                    'setting'       =>  'eight_sec_homepage_setting_contact_section_menu_title_text',
	                    'type'          =>  'text',  
	                    )                                     
	                );

	            $wp_customize->add_setting(
	                'eight_sec_homepage_setting_contact_section_page',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_integer',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_homepage_setting_contact_section_page',
	                array(
	                    'priority'=>    40,
	                    'label'   =>    esc_html__('Select Page','eight-sec'),
	                    'description' => esc_html__('Choose page to display section title and description in contact section.','eight-sec'),
	                    'section' =>    'eight_sec_homepage_setting_contact_section',
	                    'setting' =>    'eight_sec_homepage_setting_contact_section_page',
	                    'type'    =>    'dropdown-pages',
	                    )                                     
	                );
	            //select contact form 7
    			$wp_customize->add_setting('eight_sec_homepage_settings_contact_section_form',
    				array(
				        'default' => '',
				        'sanitize_callback' => 'wp_kses_post',
				   		)
				   	);
			   
			    $wp_customize->add_control( 
			    	'eight_sec_homepage_settings_contact_section_form', 
		    		array(
		    			'type' => 'text',
				        'label' => esc_html__('Enter Shortcode','eight-sec'),
				        'description' => esc_html__('Enter shortcode of Ultimate Form Builder Plugin or any other contact form plugin.','eight-sec'),
				        'section' => 'eight_sec_homepage_setting_contact_section',
			    		'priority'=>	40,
			    		)			    	
			    	);                            
		    

	    //Blog and archive Setting

	    $wp_customize->add_section(
	        'eight_sec_blog_archive_setting',
	        array(
	            'title'         =>  esc_html__('Blog/Archive Setting','eight-sec'),
	            'description'   =>  esc_html__('Settings of Blog/Archive','eight-sec'),
	            'priority'      =>  50,            
	            )
	        );

	        $wp_customize->add_setting(
	            'eight_sec_blog_archive_setting_layout',
	            array(
	                'default'           =>  'blog_image_large',
	                'sanitize_callback' =>  'eight_sec_sanitize_blog_layout',
	                )
	            );

	        $wp_customize->add_control(
	            'eight_sec_blog_archive_setting_layout',
	            array(
	                'description'   =>  esc_html__('Choose Blog/Archive Layout','eight-sec'),
	                'section'       =>  'eight_sec_blog_archive_setting',
	                'setting'       =>  'eight_sec_blog_archive_setting_layout',
	                'priority'      =>  10,
	                'type'          =>  'radio',
	                'choices'        =>  array(
	                    'blog_image_large' => esc_html__('Blog Image Large', 'eight-sec'),
	                    'blog_image_medium' => esc_html__('Blog Image Medium', 'eight-sec'),
	                    'blog_image_alt_medium' => esc_html__('Blog Image Alternate Medium', 'eight-sec'),
	                    )
	                )                   
	            );

	        $wp_customize->add_setting(
	            'eight_sec_blog_archive_setting_readmore',
	            array(
	                'default'           =>  esc_html__('Read more','eight-sec'),
	                'sanitize_callback' =>  'sanitize_text_field',
	                )
	            );

	        $wp_customize->add_control(
	            'eight_sec_blog_archive_setting_readmore',
	            array(
	                'priority'      =>  20,
	                'label'         =>  esc_html__('Read more text','eight-sec'),
	                'section'       =>  'eight_sec_blog_archive_setting',
	                'setting'       =>  'eight_sec_blog_archive_setting_readmore',
	                'type'          =>  'text',  
	                )                                     
	            );

	    //Header Setting panel

	    $wp_customize->add_panel(
	        'eight_sec_header_setting',
	        array(
	            'priority'      => 40,
	            'capability'    =>  'edit_theme_options',
	            'description'   =>  esc_html__('Header Settings of the theme','eight-sec'),
	            'theme_supports'=>  '',
	            'title'         =>  esc_html__('Header Settings','eight-sec'),
	            )
	        );
	        $wp_customize->add_section(
	            'eight_sec_header_setting_menu_section',
	            array(
	                'title'         =>  esc_html__('Menu Setting','eight-sec'),
	                'description'   =>  esc_html__('','eight-sec'),
	                'priority'      =>  50,      
	                'panel'         =>  'eight_sec_header_setting'      
	                )
	            );
	            $wp_customize->add_setting(
	                'eight_sec_header_setting_menu_section_option',
	                array(
	                    'default'           =>  '0',
	                    'sanitize_callback' =>  'eight_sec_sanitize_checkbox',
	                    )
	                );

	            $wp_customize->add_control(
	                'eight_sec_header_setting_menu_section_option',
	                array(
	                    'priority'      =>  20,
	                    'label'         =>  esc_html__('Display eight-sec menu','eight-sec'),
	                    'description'	=>	__('(Check to show eight section in the menu)','eight-sec'),
	                    'section'       =>  'eight_sec_header_setting_menu_section',
	                    'setting'       =>  'eight_sec_header_setting_menu_section_option',
	                    'type'          =>  'checkbox',  
	                    )                                     
	                );

            //search box
		   	$wp_customize->add_section(
			   	'eight_sec_header_setting_search_options', 
			   	array(
			       	'priority' => 20,
			       	'title' => esc_html__('Show Search in Header', 'eight-sec'),
			       	'panel' => 'eight_sec_header_setting'
					)
			   	);

			    $wp_customize->add_setting(
			    	'eight_sec_header_setting_search_options', 
			    	array(
					    'default' => 0,
					    'capability' => 'edit_theme_options',
					    'sanitize_callback' => 'eight_sec_sanitize_checkbox'
			   			)
			   		);

			   	$wp_customize->add_control('eight_sec_header_setting_search_options', array(
			      	'type' => 'checkbox',
			      	'label' => esc_html__('Check to Show Search in Header', 'eight-sec'),
			      	'section' => 'eight_sec_header_setting_search_options',
			      	'setting' => 'eight_sec_header_setting_search_options'
			   		)
			   	);
   
			   //Search Box Placeholder
		   	$wp_customize->add_section(
		   		'eight_sec_header_setting_search_placeholder', 
		   		array(
			       	'priority' => 30,
			       	'title' => esc_html__('Search Placeholder Text', 'eight-sec'),
			       	'panel' => 'eight_sec_header_setting'
					)
		   		);

			    $wp_customize->add_setting(
			    	'eight_sec_header_setting_search_placeholder', 
			    	array(
						'default' => esc_html__('Search...','eight-sec'),
				        'sanitize_callback' => 'sanitize_text_field',
				        'transport' => 'postMessage',
						)
			    	);
    
			    $wp_customize->add_control(
			    	'eight_sec_header_setting_search_placeholder',
			    	array(
				        'type' => 'text',
				        'section' => 'eight_sec_header_setting_search_placeholder',
				        'setting' => 'eight_sec_header_setting_search_placeholder',
			    		)
			    	);
    
			    //Search Button Text
		   	$wp_customize->add_section(
		   		'eight_sec_header_setting_search_button_text', 
		   		array(
			       	'priority' => 40,
			       	'title' => esc_html__('Search Button Text', 'eight-sec'),
			       	'panel' => 'eight_sec_header_setting'
					)
		   		);

			    $wp_customize->add_setting(
			    	'eight_sec_header_setting_search_button_text', 
			    	array(
						'default' => esc_html__('Search','eight-sec'),
				        'sanitize_callback' => 'sanitize_text_field',
				        'transport' => 'postMessage',
						)
			    	);
    
			    $wp_customize->add_control(
			    	'eight_sec_header_setting_search_button_text',
			    	array(
				        'type' => 'text',
				        'section' => 'eight_sec_header_setting_search_button_text',
				        'setting' => 'eight_sec_header_setting_search_button_text',
			    		)
			    	);
    
			    //logo Alignment
		   	$wp_customize->add_section(
		   		'eight_sec_header_setting_logo_alignment', 
		   		array(
			       	'priority' => 50,
			       	'title' => esc_html__('Logo Alignment', 'eight-sec'),
			       	'panel' => 'eight_sec_header_setting'
					)
		   		);

			    $wp_customize->add_setting(
			    	'eight_sec_header_setting_logo_alignment', 
			    	array(
				      	'default' => 'left',
				     	'capability' => 'edit_theme_options',
				      	'sanitize_callback' => 'eight_sec_radio_sanitize_alignment_logo',
			   			)
			   		);

			   	$wp_customize->add_control(
			   		'eight_sec_header_setting_logo_alignment', 
			   		array(
				      	'type' => 'radio',
				      	'label' => esc_html__('Choose the layout that you want', 'eight-sec'),
				      	'section' => 'eight_sec_header_setting_logo_alignment',
				      	'setting' => 'eight_sec_header_setting_logo_alignment',
				      	'choices' => array(
				         	'left'=> esc_html__('Left', 'eight-sec'),
				         	'center'=> esc_html__('Center', 'eight-sec'),
				         	'right'=> esc_html__('Right', 'eight-sec')
				      		)
				   		)
			   		);

	
   
			//social Settings section
			$wp_customize->add_section(
		   	'eight_sec_social_setting', 
		   	array(
		       	'priority' => 60,
		       	'title' => esc_html__('Social Setting', 'eight-sec'),
		       	//'panel' => 'eight_sec_social_setting',
				)
			);	    
		    	    
		    $wp_customize->add_setting(
		    	'eight_sec_social_setting_option_footer', 
		    	array(
		      		'default' => 'disable',
		      		'capability' => 'edit_theme_options',
		      		'sanitize_callback' => 'eight_sec_radio_sanitize_enabledisable',
		   			)
		    	);

		   	$wp_customize->add_control(
		   		'eight_sec_social_setting_option_footer', 
		   		array(
			      	'type' => 'radio',
			      	'label' => esc_html__('Enable Disable Social Icons in Footer', 'eight-sec'),
			      	'section' => 'eight_sec_social_setting',
			      	'setting' => 'eight_sec_social_setting_option_footer',
			      	'choices' => array(
			         	'enable' => esc_html__('Enable', 'eight-sec'),
			         	'disable' => esc_html__('Disable', 'eight-sec'),
		     	 		)
		   			)
		   		);
		   
		   //social facebook link
		   	$wp_customize->add_setting(
			   	'eight_sec_social_setting_facebook', 
			   	array(
					'default' => '#',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
			   	);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_facebook',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Facebook','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_facebook'
			    	)
		    	);
		    
		    //social twitter link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_twitter', 
		   		array(
					'default' => '#',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_twitter',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Twitter','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_twitter'
		    		)
		    	);
		    
		    //social googleplus link
		   	$wp_customize->add_setting(
			   	'eight_sec_social_setting_googleplus', 
			   	array(
					'default' => '#',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
			   	);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_googleplus',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Google Plus','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_googleplus'
			    	)
		    	);
		    
		     //social youtube link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_youtube', 
		   		array(
					'default' => '#',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_youtube',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('YouTube','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_youtube'
			    	)
		    	);
		    
		     //social pinterest link
		   	$wp_customize->add_setting(
			   	'eight_sec_social_setting_pinterest', 
			   	array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
			   	);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_pinterest',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Pinterest','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_pinterest'
			    	)
		    	);
		    
		    //social linkedin link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_linkedin', 
		   		array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_linkedin',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Linkedin','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_linkedin'
		    		)
		    	);
		    
		    //social flicker link
		   	$wp_customize->add_setting(
			   	'eight_sec_social_setting_flicker', 
			   	array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
			   	);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_flicker',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Flicker','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_flicker'
			    	)
		    	);
		    
		    
		    //social vimeo link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_vimeo', 
		   		array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_vimeo',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Vimeo','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_vimeo'
		    		)
		    	);
		    
		    //social stumbleupon link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_stumbleupon', 
		   		array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_flicker',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Stumbleupon','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_stumbleupon'
			    	)
		    	);
		    
		    //social instagram link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_instagram', 
		   		array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_instagram',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Instagram','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_instagram'
			    	)
		    	);
		    
		    //social soundcloud link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_soundcloud', 
		   		array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_soundcloud',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Sound Cloud','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_soundcloud'
		    		)
		    	);
		    
		    //social github link
		   	$wp_customize->add_setting(
			   	'eight_sec_social_setting_github', 
			   	array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
			   	);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_github',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Git Hub','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_github'
		    		)
		    	);
		    
		    //social tumbler link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_tumbler', 
		   		array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_tumbler',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Tumbler','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_tumbler'
			    	)
		    	);
		    
		    //social skype link
		   	$wp_customize->add_setting(
		   		'eight_sec_social_setting_skype', 
		   		array(
					'default' => '',
			        'sanitize_callback' => 'sanitize_text_field',
					)
		   		);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_skype',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('Skype','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_skype'
			    	)
		    	);
		    
		    //social Rss link
		   	$wp_customize->add_setting(
			   	'eight_sec_social_setting_rss', 
			   	array(
					'default' => '',
			        'sanitize_callback' => 'eight_sec_sanitize_url',
					)
			   	);
		    
		    $wp_customize->add_control(
		    	'eight_sec_social_setting_rss',
		    	array(
			        'type' => 'text',
			        'label' => esc_html__('RSS','eight-sec'),
			        'section' => 'eight_sec_social_setting',
			        'setting' => 'eight_sec_social_setting_rss'
			    	)
			    );         		
	
	}
	add_action( 'customize_register', 'eight_sec_customizer' );

?>
