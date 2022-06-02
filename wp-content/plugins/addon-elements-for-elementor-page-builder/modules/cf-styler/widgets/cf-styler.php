<?php

namespace WTS_EAE\Modules\CfStyler\Widgets;

use Elementor\Conditions;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CfStyler extends EAE_Widget_Base
{
    public function get_name()
    {
        return 'CfStyler';
    }

    public function get_title()
    {
        return __('EAE - Cf7 Styler', 'wts-eae');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories()
    {
        return ['wts-eae'];
    }

    public function get_keywords()
    {
        return [
            'cf7',
            'contact',
            'form',
            'styler',
            'cf',
            'eae',
        ];
    }

    protected function get_form()
    {
        $formList = [];

        if (class_exists('WPCF7_ContactForm')) {
            $args = array(
                'post_type'      => 'wpcf7_contact_form',
                'posts_per_page' => -1,
            );
            $forms = get_posts($args);
            $formList['0'] = 'Select';
            if ($forms) {
                foreach ($forms as $form) {
                    $formList[$form->ID] = $form->post_title;
                }
            }
        }

        if (empty($formList)) {
            $formList = array(
                '-1' => __('You have not added any Contact Form 7 yet.', 'wts-eae'),
            );
        }
        return $formList;
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_general',
            [
                'label' => __('General', 'wts-eae'),
            ],
        );

        // Select Form
        $this->add_control(
            'select_form',
            array(
                'label'   => __(
                    'Select Form',
                    'wts-eae'
                ),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_form(),
                'default' => '0',
                'help'    => __('Select a form', 'wts-eae'),
            )
        );

        // Label On/ Off
        // $this->add_control(
        // 	'show_title',
        // 	[
        // 		'label' => __( 'Labels', 'wts-eae' ),
        // 		'type' => Controls_Manager::SWITCHER,
        // 		'label_on' => __( 'Show', 'wts-eae' ),
        // 		'label_off' => __( 'Hide', 'wts-eae' ),
        // 		'return_value' => 'yes',
        // 		'default' => 'yes',
        //         'prefix_class' => 'eae-cf7-label-',
        // 	],
        // );

        $this->end_controls_section();

        // Error/ Validation section
        $this->start_controls_section(
            'error_section',
            array(
                'label' => __('Error', 'wts-eae'),
            )
        );

        // Error validation messages On/ Off
        $this->add_control(
            'show_validation_errors',
            [
                'label' => __('Validation Errors', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'default' => 'show',
                'options' => [
                    'show'  => __('Show', 'wts-eae'),
                    'hide' => __('Hide', 'wts-eae'),
                ],
                'prefix_class' => 'eae-cf7-error-validation-',
            ]
        );

        // Error output message On/ Off
        $this->add_control(
            'show_output_error',
            [
                'label' => __('Response message', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'default' => 'show',
                'options' => [
                    'show'  => __('Show', 'wts-eae'),
                    'hide' => __('Hide', 'wts-eae'),
                ],
                'prefix_class' => 'eae-cf7-error-output-',
            ]
        );

        $this->end_controls_section();

        // Style Tab

        // Text Field
        $this->start_controls_section(
            'text_field',
            array(
                'label' => __('Input/ Textarea', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        // Typography

        // General Field Palceholder Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_field_placeholder_typography',
                'label' => __('Typography', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 input:not([type=submit]):not([type=checkbox]):not([type=radio]),{{WRAPPER}} .wts-eae-main .wpcf7 select, {{WRAPPER}} .wts-eae-main .wpcf7 textarea,.wts-eae-main .wpcf7 input::placeholder, .wts-eae-main .wpcf7 textarea::placeholder',
            ]
        );

        // Field Size
        $this->add_responsive_control(
            'field_width',
            [
                'label' => __('Field Width', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-text, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-email, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-tel, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-number, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-quiz, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-date, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-url, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-select' => 'width:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Field Alignment
        $this->add_responsive_control(
            'field_alignment',
            array(
                'label'     => __('Field Alignment', 'wts-eae'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => array(
                    'left'   => array(
                        'title' => __('Left', 'wts-eae'),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'wts-eae'),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => __('Right', 'wts-eae'),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .wts-eae-main .wpcf7' => 'text-align: {{VALUE}};',
                ),
            )
        );

        // General Field type
        $this->add_control(
            'field_style',
            array(
                'label'        => __('Field Style', 'wts-eae'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'box',
                'options'      => array(
                    'box'       => __('Box', 'wts-eae'),
                    'underline' => __('Underline', 'wts-eae'),
                ),
                'prefix_class' => 'wts-cf7-style-',
            )
        );

        // Tabs
        $this->start_controls_tabs(
            'general_field_tabs'
        );

        // Normal
        $this->start_controls_tab(
            'general_field_normal_tab',
            [
                'label' => 'Normal',
            ]
        );

        // Field Color normal
        $this->add_control(
            'field_color_normal',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .wts-eae-main .wpcf7 select, {{WRAPPER}} .wts-eae-main .wpcf7 textarea, {{WRAPPER}} .wts-eae-main .wpcf7 span.wpcf7-list-item,{{WRAPPER}} .wts-eae-main .wpcf7 input::placeholder,{{WRAPPER}} .wts-eae-main .wpcf7 textarea::placeholder' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Field Background Color normal

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'field_background_normal',
                'label' => __('Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 input:not([type="submit"]):not([type="radio"]):not([type="checkbox"]),{{WRAPPER}} .wts-eae-main .wpcf7 textarea
                ,{{WRAPPER}} .wts-eae-main .wpcf7 select',
            ]
        );

        // Field Border Style Box
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_border_box',
                'label' => __('Border', 'wts-eae'),
                'selector'  => '{{WRAPPER}} .wts-eae-main .wpcf7 input:not([type=submit]):not([type=radio]):not([type=checkbox]),{{WRAPPER}} .wts-eae-main .wpcf7 textarea
                ,{{WRAPPER}} .wts-eae-main .wpcf7 select, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-captchar',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'    => 1,
                            'right'  => 1,
                            'bottom' => 1,
                            'left'   => 1,
                            'unit'   => 'px',
                        ],
                    ],
                    'color'  => [
                        'global' => [
                            'default' => Global_Colors::COLOR_SECONDARY,
                        ]
                    ],
                ],
                'condition' => [
                    'field_style' => 'box',
                ],

            ],
        );

        // Field Border Style Underline
        $this->add_responsive_control(
            'field_border_underline',
            [
                'label' => __('Border', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                    'color' => Global_Colors::COLOR_SECONDARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-text, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-textarea,
                    {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-email, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-date,
                    {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-number, {{WRAPPER}} .wts-eae-main .wpcf7 select,
                    {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-captchar, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-quiz, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-file' => 'border-bottom-style:solid; border-bottom-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'field_style' => 'underline',
                ],
            ]
        );

        // Field Border Color Underline
        $this->add_control(
            'field_border_color_underline',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-text, {{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-textarea,
                    {{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-email, {{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-date,
                    {{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-number , {{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 select,
                    {{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-captchar ,{{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-quiz, {{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-file, {{WRAPPER}}.wts-cf7-style-underline .wts-eae-main .wpcf7 .wpcf7-tel' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'field_style' => 'underline',
                ],
            ]
        );

        // Field Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __('Box Shadow', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=text],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=email],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap textarea, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=url],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=quiz],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=number],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=file],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap .wpcf7-select,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=tel],{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-captchar',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'field_border_radius',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .wts-eae-main .wpcf7 select, {{WRAPPER}} .wts-eae-main .wpcf7 textarea, {{WRAPPER}} .wts-eae-main .wpcf7 span.wpcf7-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Focus
        $this->start_controls_tab(
            'general_field_focus_tab',
            [
                'label' => 'Focus',
            ]
        );

        // Field Color focus
        $this->add_control(
            'field_color_focus',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=text]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=email]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap textarea:focus, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=url]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=quiz]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=number]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=file]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap .wpcf7-select:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=tel]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-captchar:focus' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Field Background Color focus
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'field_background_focus',
                'label' => __('Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=text]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=email]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap textarea:focus, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=url]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=quiz]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=number]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=file]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap .wpcf7-select:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=tel]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-captchar:focus',
            ],
        );

        // Field Active Border Color
        $this->add_control(
            'active_border_color_focus',
            [
                'label' => __('Border Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=text]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=email]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap textarea:focus, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=url]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=quiz]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=number]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=file]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap .wpcf7-select:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=tel]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-captchar:focus' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        // Field Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_focus',
                'label' => __('Box Shadow', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=text]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=email]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap textarea:focus, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=url]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=quiz]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=number]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=file]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap .wpcf7-select:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=tel]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-captchar:focus',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'field_border_radius_focus',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=text]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=email]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap textarea:focus, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=url]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=quiz]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=number]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=date]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=file]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap .wpcf7-select:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap input[type=tel]:focus,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-captchar:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Field Padding
        $this->add_responsive_control(
            'field_padding',
            [
                'label' => __('Padding', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .wts-eae-main .wpcf7 select, {{WRAPPER}} .wts-eae-main .wpcf7 textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Textarea Part starts
        $this->add_control(
            'general_field_textarea_options',
            [
                'label' => __('Textarea', 'wts-eae'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Textarea Size -> Width
        $this->add_responsive_control(
            'textarea_width',
            [
                'label' => __('Textarea Width', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 textarea' => 'width:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Textarea Size -> Height
        $this->add_responsive_control(
            'textarea_height',
            [
                'label' => __('Textarea Height', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 textarea' => 'height:{{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        // Text Field
        $this->start_controls_section(
            'label_field',
            array(
                'label' => __('Label', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE,
                // 'condition' => [
                //     'show_title' => 'yes',
                // ],
            )
        );

        // Label Section

        // Text Field Label Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_field_label_typography',
                'label' => __('Typography', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 label,{{WRAPPER}} .wts-eae-main .wpcf7 :not(.error-field)',
            ]
        );

        // Field Label Color
        $this->add_control(
            'field_label_color',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 label, {{WRAPPER}} .wpcf7-quiz-label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Radio and Checkboxes
        $this->start_controls_section(
            'radios_and_checkboxes_field',
            array(
                'label' => __('Radio & Checkbox', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );


        // RC Field Label Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rc_field_label_typography',
                'label' => __('Typography', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"]+span, {{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]+span',
            ]
        );

        // RC Field Size
        $this->add_responsive_control(
            'rc_field_size',
            [
                'label' => __('Size', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"],{{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]' => 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]:checked,{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"]:checked' => 'font-size:calc({{SIZE}}{{UNIT}}/1.2);',
                ],
            ]
        );

        // RC Tabs
        $this->start_controls_tabs(
            'rc_tabs'
        );

        // RC Normal Tab
        $this->start_controls_tab(
            'rc_normal_tab',
            [
                'label' => __('Normal', 'wts-eae'),
            ]
        );

        // RC Label Color
        $this->add_control(
            'rc_label_color',
            [
                'label' => __('Label Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"]+span,
                    {{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]+span' => 'color: {{VALUE}}',
                ],
            ]
        );

        // RC Background Color
        $this->add_control(
            'rc_color',
            [
                'label' => __('Background Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"], {{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        // RC Border Style Box
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'rc_border_box',
                'label' => __('Border', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control input[type="radio"], {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control input[type="checkbox"]',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'    => 1,
                            'right'  => 1,
                            'bottom' => 1,
                            'left'   => 1,
                            'unit'   => 'px',
                        ],
                    ],
                    'color'  => [
                        'global' => [
                            'default' => Global_Colors::COLOR_SECONDARY,
                        ]
                    ],
                ],
            ],
        );

        // RC Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'rc_box_shadow',
                'label' => __('Box Shadow', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"], {{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]',
            ]
        );

        // RC Border Radius
        $this->add_responsive_control(
            'rc_field_border_radius',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // RC Selected Tab
        $this->start_controls_tab(
            'rc_selected_tab',
            [
                'label' => __('Selected', 'wts-eae'),
            ]
        );

        // RC Sign Color Checked
        // $this->add_control(
        //     'rc_sign_color_checked',
        //     [
        //         'label' => __('Sign Color', 'wts-eae'),
        //         'type' => Controls_Manager::COLOR,
        //         'selectors' => [
        //             '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"]:checked,{{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]:checked' => 'color: {{VALUE}}',
        //         ],
        //     ]
        // );

        // RC Selected Label Color
        $this->add_control(
            'rc_selected_label_color',
            [
                'label' => __('Label Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"]:checked+span, {{WRAPPER}} .wts-eae-main .wpcf7 input[type="checkbox"]:checked+span' => 'color: {{VALUE}}',
                ],
            ]
        );

        // RC Selected Background Color
        $this->add_control(
            'rc_selected_background_color',
            [
                'label' => __('Background Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input[type="radio"]:checked, {{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-list-item input[type="checkbox"]:checked' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        // RC Selected Border Color
        $this->add_control(
            'rc_selected_border_color',
            [
                'label' => __('Border Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'default' => '#61ce70',
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-list-item input[type="radio"]:checked,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-list-item input[type="checkbox"]:checked' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        // RC Selected Border Radius
        $this->add_responsive_control(
            'rc_border_radius_focus',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-list-item input[type="checkbox"]:checked' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // RC Field Padding
        $this->add_responsive_control(
            'rc_field_padding',
            [
                'label' => __('Padding', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-list-item' => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // RC Indentation
        $this->add_responsive_control(
            'rc-margin-left',
            [
                'label' => __('Indentation', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-list-item input[type="radio"]+span:before,{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-list-item input[type="checkbox"]+span:before' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'checkbox_orientation_spacing',
            [
                'label' => __('Checkbox', 'wts-eae'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Checkbox field orientation
        $this->add_control(
            'checkbox_field_orientation',
            [
                'label' => __('Orientation', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal'  => __('Horizontal', 'wts-eae'),
                    'vertical' => __('Verical', 'wts-eae'),
                ],
                'prefix_class' => 'checkbox-orientation-',
            ]
        );

        // Checkbox Spacing
        $this->add_responsive_control(
            'checkbox-spacing',
            [
                'label' => __('Spacing', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ]
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    // Checkbox Horizontal Spacing
                    '.checkbox-orientation-horizontal .wts-eae-main .wpcf7 .wpcf7-list-item input[type="checkbox"]+span' => 'margin-right: {{SIZE}}{{UNIT}};',
                    // Checkbox Vertical Spacing
                    '.checkbox-orientation-vertical .wts-eae-main .wpcf7-checkbox .wpcf7-list-item' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );


        $this->add_control(
            'radio_orientation_spacing',
            [
                'label' => __('Radio', 'wts-eae'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Radio field orientation
        $this->add_control(
            'radio_field_orientation',
            [
                'label' => __('Orientation', 'wts-eae'),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal'  => __('Horizontal', 'wts-eae'),
                    'vertical' => __('Verical', 'wts-eae'),
                ],
                'prefix_class' => 'radio-orientation-',
            ]
        );


        // Radio Spacing
        $this->add_responsive_control(
            'radio-spacing',
            [
                'label' => __('Spacing', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    // Radio Horizontal Spacing
                    '.radio-orientation-horizontal .wts-eae-main .wpcf7 .wpcf7-list-item input[type="radio"]+span' => 'margin-right: {{SIZE}}{{UNIT}};',
                    // Radio Vertical Spacing
                    '.radio-orientation-vertical .wts-eae-main .wpcf7-radio .wpcf7-list-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Submit Button
        $this->start_controls_section(
            'submit_button_field',
            array(
                'label' => __('Submit Button', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        // Submit Field Label Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submit_field_label_typography',
                'label' => __('Typography', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit',
            ]
        );

        // Submit Button Field Size
        $this->add_control(
            'button_size',
            array(
                'label'        => __('Size', 'wts-eae'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'sm',
                'options'      => [
                    'sm' => __('Small', 'wts-eae'),
                    'md' => __('Medium', 'wts-eae'),
                    'lg' => __('Large', 'wts-eae'),
                    'xl' => __('Block', 'wts-eae'),
                ],
                'prefix_class' => 'cf7-btn-size-',
            )
        );

        // Submit Button Field Alignment
        $this->add_responsive_control(
            'button_field_alignment',
            [
                'label'     => __('Alignment', 'wts-eae'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => array(
                    'left'   => array(
                        'title' => __('Left', 'wts-eae'),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'wts-eae'),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => __('Right', 'wts-eae'),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'prefix_class' => 'cf7-btn-alignment-'
            ],
        );

        // Tabs
        $this->start_controls_tabs(
            'button_field_tabs'
        );

        $this->start_controls_tab(
            'button_field_normal_tab',
            [
                'label' => 'Normal',
            ]
        );

        // Submit Field Color
        $this->add_control(
            'submit_field_color',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Submit Field Background Color

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'submit_field_background',
                'label' => __('Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit',
            ]
        );

        // Submit Field Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'submit_field_border',
                'label' => __('Border', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'    => 0,
                            'right'  => 0,
                            'bottom' => 0,
                            'left'   => 0,
                            'unit'   => 'px',
                        ],
                    ],
                    'color'  => [
                        'global' => [
                            'default' => Global_Colors::COLOR_SECONDARY,
                        ]
                    ],
                ],
            ],
        );

        // Submit Field Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submit_field_box_shadow',
                'label' => __('Box Shadow', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit',
            ]
        );

        // Submit Field Border Radius
        $this->add_responsive_control(
            'submit_field_border_radius',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_field_hover_tab',
            [
                'label' => 'Hover',
            ]
        );

        // Submit Field Color on hover
        $this->add_control(
            'submit_field_color_hover',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Submit Field Background Color on hover

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'submit_field_background_hover',
                'label' => __('Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit:hover',
            ]
        );

        // Submit Field Border Color on hover
        $this->add_control(
            'submit_border_color_focus',
            [
                'label' => __('Border Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        // Submit Field Box Shadow on hover
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submit_field_box_shadow_hover',
                'label' => __('Box Shadow', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit:hover',
            ]
        );

        // Submit Field Border Radius on hover
        $this->add_responsive_control(
            'submit_field_border_radius_hover',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        // Submit Button Field Padding
        $this->add_responsive_control(
            'button_field_padding',
            [
                'label' => __('Padding', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit' => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Submit Button Field Margin
        $this->add_responsive_control(
            'margin-top',
            [
                'label' => __('Margin Top', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-submit' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Success /Error Messages Field
        $this->start_controls_section(
            'success_error_messages_field',
            array(
                'label' => __('Success /Error Messages', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'show_validation_errors', 'operator' => '||', 'value' => 'show',
                        ],
                        [
                            'name' => 'show_output_error', 'operator' => '||', 'value' => 'show',
                        ],
                    ],
                ],
            )
        );

        $this->add_control(
            'show_response',
            [
                'label' => __('Preview Response', 'wts-eae'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'wts-eae'),
                'label_off' => __('Hide', 'wts-eae'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // SCM field typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'scm_field_label_typography',
                'label' => __('Typography', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .sent-box,{{WRAPPER}} .wts-eae-main .error-box',
            ]
        );

        // SCM Field Alignment
        $this->add_responsive_control(
            'scm_field_alignment',
            [
                'label'     => __('Alignment', 'wts-eae'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => array(
                    'left'   => array(
                        'title' => __('Left', 'wts-eae'),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'wts-eae'),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => __('Right', 'wts-eae'),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .sent-box,{{WRAPPER}} .wts-eae-main .error-box' => 'text-align: {{VALUE}}',
                ],
            ],
        );

        // Tabs
        $this->start_controls_tabs(
            'success_error_messages_field_tabs'
        );

        // Success Tab
        $this->start_controls_tab(
            'success_messages_tab',
            [
                'label' => 'Success',
                'condition' => [
                    'show_output_error' => 'show',
                ],
            ]
        );

        // SCM Field Color success
        $this->add_control(
            'scm_field_color_success',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .sent .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .sent-box' => 'color: {{VALUE}}',
                ],
            ]
        );

        // SCM Field Background Color success

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'scm_field_background_success',
                'label' => __('Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .sent .wpcf7-response-output, {{WRAPPER}} .wts-eae-main .sent-box',
            ]
        );

        // SCM Field Border Style success
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'scm_field_border_success',
                'label' => __('Border', 'wts-eae'),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'    => 0,
                            'right'  => 0,
                            'bottom' => 0,
                            'left'   => 0,
                            'unit'   => 'px',
                        ],
                    ],
                    'color'  => [
                        'global' => [
                            'default' => Global_Colors::COLOR_SECONDARY,
                        ]
                    ],
                ],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .sent .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .sent-box',
            ],
        );

        // SCM Field Box Shadow success
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'scm_field_box_shadow_success',
                'label' => __('Box Shadow', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .sent .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .sent-box',
            ]
        );

        // SCM Field Border Radius success
        $this->add_responsive_control(
            'scm_field_border_radius_success',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .sent .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .sent-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Error Tab
        $this->start_controls_tab(
            'error_messages_tab',
            [
                'label' => 'Error',
                'condition' => [
                    'show_output_error' => 'show',
                ],
            ],
        );

        // SCM Field Color error
        $this->add_control(
            'scm_field_color_error',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 :not(.sent) .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .error-box' => 'color: {{VALUE}}',
                ],

            ]
        );

        // SCM Field Background Color error

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'scm_field_background_error',
                'label' => __('Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 :not(.sent) .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .error-box',
            ]
        );

        // SCM Field Border Style error
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'scm_field_border_error',
                'label' => __('Border', 'wts-eae'),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'    => 0,
                            'right'  => 0,
                            'bottom' => 0,
                            'left'   => 0,
                            'unit'   => 'px',
                        ],
                    ],
                    'color'  => [
                        'global' => [
                            'default' => Global_Colors::COLOR_SECONDARY,
                        ]
                    ],
                ],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 :not(.sent) .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .error-box',
            ],
        );

        // SCM Field Box Shadow error
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'scm_field_box_shadow_error',
                'label' => __('Box Shadow', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 :not(.sent) .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .error-box',
            ]
        );

        // SCM Field Border Radius error
        $this->add_responsive_control(
            'scm_field_border_radius_error',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 :not(.sent) .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .error-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Validation Tab
        $this->start_controls_tab(
            'validation_error_messages_tab',
            [
                'label' => 'Validation',
                'condition' => [
                    'show_validation_errors' => 'show',
                ],
            ]
        );

        // Validation Error field typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'validation_error_field_label_typography',
                'label' => __('Typography', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-not-valid-tip,{{WRAPPER}} .wts-eae-main .wpcf7 .error-field',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16',
                        ],
                    ],
                ],
            ]
        );

        // Validation Error Field Color error
        $this->add_control(
            'field_color_error',
            [
                'label' => __('Color', 'wts-eae'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-not-valid-tip,{{WRAPPER}} .wts-eae-main .wpcf7 .error-field' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Validation Error Field Background Color error

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'field_background_error',
                'label' => __('Background', 'wts-eae'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-not-valid-tip,{{WRAPPER}} .wts-eae-main .wpcf7 .error-field',
            ]
        );

        // Validation Error Field Border Style error
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'validation_error_field_border_error',
                'label' => __('Border', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-not-valid-tip,{{WRAPPER}} .wts-eae-main .wpcf7 .error-field',
            ],
        );

        // Validation Error Field Box Shadow error
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'validation_error_field_box_shadow_error',
                'label' => __('Box Shadow', 'wts-eae'),
                'selector' => '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-not-valid-tip,{{WRAPPER}} .wts-eae-main .wpcf7 .error-field',
            ]
        );

        // Validation Error Field Border Radius error
        $this->add_responsive_control(
            'validation_error_field_border_radius_error',
            [
                'label' => __('Border Radius', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-not-valid-tip,{{WRAPPER}} .wts-eae-main .wpcf7 .error-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Validation Error Field Padding
        $this->add_responsive_control(
            'validation_error_field_padding',
            [
                'label' => __('Padding', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-not-valid-tip,{{WRAPPER}} .wts-eae-main .wpcf7 .error-field' => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Validation error field margin top
        $this->add_responsive_control(
            'validation-error-field-margin-top',
            [
                'label' => __('Margin Top', 'wts-eae'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-not-valid-tip,{{WRAPPER}} .wts-eae-main .wpcf7 .error-field' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // SCM Field Padding
        $this->add_responsive_control(
            'scm_field_padding',
            [
                'label' => __('Padding', 'wts-eae'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-response-output,{{WRAPPER}} .wts-eae-main .sent-box,{{WRAPPER}} .wts-eae-main .error-box' => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Spacing section
        $this->start_controls_section(
            'input_spacing',
            array(
                'label' => __('Spacing', 'wts-eae'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        // Spacing 

        $this->add_responsive_control(
            'label_input_spacing',
            array(
                'label'      => __('Between Label and Input', 'wts-eae'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em'),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 5,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .wts-eae-main .wpcf7 input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .wts-eae-main .wpcf7 select, {{WRAPPER}} .wts-eae-main .wpcf7 textarea, {{WRAPPER}} .wts-eae-main .wpcf7 span.wpcf7-list-item' => 'margin-top: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'cform7_input_margin_bottom',
            array(
                'label'      => __('Between Fields', 'wts-eae'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em'),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 10,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .wts-eae-main .wpcf7 .wpcf7-form-control-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};display: block;',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $formID =  $settings['select_form'];
        if ($formID == 0) {
            echo "Select a form";
        } else { ?>
            <div class="wts-eae-main">
                <?php
                echo do_shortcode('[contact-form-7 id=' . $formID . ']');
                if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                    if ($settings['show_response'] == 'yes') { ?>
                        <div class='wpcf7-response-output sent-box'>Thank you for your message. It has been sent.</div>
                        <div class='wpcf7-response-output error-box validation-field-box' id="error-field-hidden">There was an error trying to send your message. Please try again later.</div>
                <?php
                    }
                }
                ?>
            </div>
<?php }
    }
}
