<?php
/*
Plugin Name: FullPage for WPBakery Page Builder
Plugin URI: https://www.meceware.com/fp/
Author: Mehmet Celik
Author URI: https://www.meceware.com/
Version: 2.0.7
Description: Create beautiful scrolling fullscreen web sites with WPBakery Page Builder and WordPress, fast and simple. WPBakery Page Builder Addon of FullPage JS implementation.
Text Domain: mcw_fullpage
*/

/* Copyright 2015 - 2019 Mehmet Celik */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

// Include meta box
require_once dirname( __FILE__ ) . '/mcw_metabox/mcw_metabox.php';

if (!class_exists('MCW_FullPage')) {
  class MCW_FullPage {
    // FullPageJS version
    protected $fullpage_js_version = '3.0.7';
    // Lease wpb requiered version
    protected $vc_RequiredVersion = '4.8';

    // Shortcode name tag
    protected $tag = 'mcw_fullpage';
    // WPBakery Page Builder Group Name
    protected $vcGroupName = 'Full Page';

    // Full page script related definitions

    // Full page wrapper anchor name
    protected $an_fullpage = 'mcw_full_page';
    // Section class name
    protected $cn_section = 'mcw_fp_section';
    // Slide class name
    protected $cn_slide = 'mcw_fp_slide';
    // Fixed top class name
    protected $cn_fixed_top = 'mcw_fp_fixed_top';
    protected $cn_fixed_bottom = 'mcw_fp_fixed_bottom';

    // Meta box class
    protected $meta_box = null;

    // Meta Box Name
    // IMPORTANT: Change on template as well
    protected $meta_box_id = 'mcw_fp_settings';

    // Meta Box Field ID's
    protected $id_fullPageEnable = 'mcw_fp_enable';

    // Navigation section ID's
    protected $id_LockAnchors = 'mcw_fp_lockanchors';
    protected $id_Navigation = 'mcw_fp_navigation';
    protected $id_ShowActiveTooltip = 'mcw_fp_showactivetooltip';
    protected $id_BigSectionNavigation = 'mcw_fp_bigsectionnavigation';
    protected $id_SectionColor = 'mcw_fp_sectioncolor';
    protected $id_SectionHoverColor = 'mcw_fp_sectionhovercolor';
    protected $id_SectionActiveColor = 'mcw_fp_sectionactivecolor';
    protected $id_SectionNavigationStyle = 'mcw_fp_sectionnavigationstyle';
    protected $id_SlideNavigation = 'mcw_fp_slidenavigation';
    protected $id_SlideNavigationStyle = 'mcw_fp_slidenavigationstyle';
    protected $id_SlideColor = 'mcw_fp_slidecolor';
    protected $id_SlideHoverColor = 'mcw_fp_slidehovercolor';
    protected $id_SlideActiveColor = 'mcw_fp_slideactivecolor';
    protected $id_BigSlideNavigation = 'mcw_fp_bigslidenavigation';

    // Scrolling section ID's
    protected $id_AutoScrolling = 'mcw_fp_autoscrolling';
    protected $id_ScrollingSpeed = 'mcw_fp_scrollingspeed';
    protected $id_FitToSection = 'mcw_fp_fittosection';
    protected $id_FitToSectionDelay = 'mcw_fp_fittosectiondelay';
    protected $id_ScrollBar = 'mcw_fp_scrollbar';
    protected $id_Easing = 'mcw_fp_easing';
    protected $id_LoopBottom = 'mcw_fp_loopbottom';
    protected $id_LoopTop = 'mcw_fp_looptop';
    protected $id_ContinuousVertical = 'mcw_fp_contvertical';
    protected $id_LoopHorizontal = 'mcw_fp_loophorizontal';
    protected $id_BigSectionsDestination = 'mcw_fp_bigsectionsdestination';
    protected $id_ScrollOverflow = 'mcw_fp_scrolloverflow';
    protected $id_ScrollOverflowFadeScrollbars = 'mcw_fp_hidescrollbars';
    protected $id_ScrollOverflowHideScrollbars = 'mcw_fp_fadescrollbars';
    protected $id_ScrollOverflowInteractiveScrollbars = 'mcw_fp_interactivescrollbars';

    // Design section ID's
    protected $id_ControlArrows = 'mcw_fp_controlarrows';
    protected $id_VerticalCentered = 'mcw_fp_verticalcentered';
    protected $id_Resize = 'mcw_fp_resize';
    protected $id_ResponsiveWidth = 'mcw_fp_respwidth';
    protected $id_ResponsiveHeight = 'mcw_fp_respheight';
    protected $id_PaddingTop = 'mcw_fp_paddingtop';
    protected $id_PaddingBottom = 'mcw_fp_paddingbottom';
    protected $id_TooltipBackground = 'mcw_fp_tooltipbackground';
    protected $id_TooltipColor = 'mcw_fp_tooltipcolor';
    protected $id_FixedElements = 'mcw_fp_fixedelements';
    protected $id_NormalScrollElements = 'mcw_fp_normalscrollelements';

    // Accessibility section ID's
    protected $id_KeyboardScrolling = 'mcw_fp_keyboardscrolling';
    protected $id_AnimateAnchor = 'mcw_fp_animateanchor';
    protected $id_RecordHistory = 'mcw_fp_recordhistory';
    protected $id_ExtraParameters = 'mcw_fp_extraparameters';
    protected $id_VerticallyCentered = 'mcw_fp_vertically_centered';
    protected $id_ControlArrow = 'mcw_fp_control_arrows';

    // Events section ID's
    protected $id_afterLoadEnable = 'mcw_fp_afterloadenable';
    protected $id_evt_afterLoad = 'mcw_fp_evt_afterload';
    protected $id_onLeaveEnable = 'mcw_fp_onleaveenable';
    protected $id_evt_onLeave = 'mcw_fp_evt_onleave';
    protected $id_afterRenderEnable = 'mcw_fp_afterrenderenable';
    protected $id_evt_afterRender = 'mcw_fp_evt_afterrender';
    protected $id_afterResizeEnable = 'mcw_fp_afterresizeenable';
    protected $id_evt_afterResize = 'mcw_fp_evt_afterresize';
    protected $id_afterSlideLoadEnable = 'mcw_fp_afterslideloadenable';
    protected $id_evt_afterSlideLoad = 'mcw_fp_evt_afterslideload';
    protected $id_onSlideLeaveEnable = 'mcw_fp_onslideleaveenable';
    protected $id_evt_onSlideLeave = 'mcw_fp_evt_onslideleave';
    protected $id_beforefullpage = 'mcw_fp_beforefullpage';
    protected $id_evt_beforefullpage = 'mcw_fp_evt_beforefullpage';
    protected $id_afterfullpage = 'mcw_fp_afterfullpage';
    protected $id_evt_afterfullpage = 'mcw_fp_evt_afterfullpage';
    protected $id_afterresponsive = 'mcw_fp_afterresponsize';
    protected $id_evt_afterresponsive = 'mcw_fp_evt_afterresponsive';

    // Customization section ID's
    protected $id_cust_enableVCAnim = 'mcw_fp_cust_enablevcanim';
    protected $id_cust_enableVCAnimReset = 'mcw_fp_cust_enablevcanimreset';
    protected $id_cust_forceRemoveThemeMargins = 'mcw_fp_cust_forceremovethememargins';
    protected $id_cust_videoautoplay = 'mcw_fp_cust_videoautoplay';
    protected $id_cust_forceFixedThemeHeader = 'mcw_fp_cust_forcefixedthemeheader';
    protected $id_cust_forceFixedThemeHeaderSelector = 'mcw_fp_cust_forcefixedthemeheadersel';
    protected $id_cust_pbContainerFix = 'mcw_fp_cust_pbContainerFix';
    protected $id_cust_pbContainerSelector = 'mcw_fp_cust_pbContainerSelector';
    protected $id_cust_extensions = 'mcw_fp_cust_extensions';
    protected $id_cust_extensionUrl = 'mcw_fp_cust_extension_url';

    // Advanced section ID's
    protected $id_EnableTemplate = 'mcw_fp_enabletemplate';
    protected $id_TemplateRedirect = 'mcw_fp_templateredirect';
    protected $id_TemplatePath = 'mcw_fp_templatepath';
    protected $id_RemoveThemeJS = 'mcw_fp_removethemejs';
    protected $id_RemoveJS = 'mcw_fp_removejs'; // Change on template as well
    protected $id_SectionSelector = 'mcw_fp_sectionselector';
    protected $id_SlideSelector = 'mcw_fp_slideselector';

    // WPBakery Page Builder Names
    protected $vc_SectionBehaviour = 'mcw_fp_auto_height';
    protected $vc_Anchor = 'mcw_fp_anchor';
    protected $vc_Tooltip = 'mcw_fp_tooltip';
    protected $vc_ColumnSlides = 'mcw_fp_column_slide';
    protected $vc_NoScrollbar = 'mcw_fp_no_scrollbar';
    protected $vc_SectionMainColor = 'mcw_fp_main_color';
    protected $vc_SectionHoverColor = 'mcw_fp_hover_color';
    protected $vc_SectionActiveColor = 'mcw_fp_active_color';
    // WPBakery Page Builder Class Names
    protected $vc_ValidRowClasses = array( 'vc_row', 'wpb_row', 'x-content-band' );
    protected $vc_ValidColClasses = array( 'vc_column', 'wpb_column', 'vc_column_container' );
    protected $vc_RowCounter = 0;

    // Customizations
    protected $customizations = array();

    // Class constructor
    public function __construct() {
      // Add fullpage js and css files
      add_action( 'wp_enqueue_scripts', array($this, 'on_wp_enqueue_scripts') );
      // Add fullpage script
      add_action( 'wp_head', array($this, 'on_wp_head') );
      add_action( 'wp_footer', array($this, 'on_wp_footer'), 50 );
      // Add full page div wrapper to the content
      add_filter( 'the_content', array($this, 'on_the_content'), 1000 );
      // Template redirect
      add_action( 'template_redirect', array($this, 'on_template_redirect') );
      // Template include
      add_filter( 'template_include', array($this, 'on_template_include') );
      // Remove unwanted JS from header
      add_action( 'wp_print_scripts', array($this, 'on_wp_print_scripts') );
      // Add body class
      add_filter( 'body_class', array($this, 'on_body_class') );

      if ( defined('WPB_VC_VERSION') ) {
        // execute shortcode hook
        add_filter('vc_shortcode_output', array($this, 'on_vc_shortcode_output'), 10, 3);
      }

      // ******************************************************************************************
      // Admin side

      // Initialize admin interface to add params in vc
      add_action( 'admin_init', array($this, 'on_admin_init') );
    }

    private function translate( $text ) {
      return esc_html( __( $text, $this->tag ) );
    }

    // Return specified value in double quotes
    private function getValAsString($val) {
      return '"' . $val . '"';
    }

    // Implode the given parameters
    private function implodeParams($parameters, $extras = '') {
      $paramStr = '';
      foreach ($parameters as $key => $value) {
        $paramStr .= $key . ':' . $value . ',';
      }
      $paramStr .= $extras;
      return '{' . rtrim($paramStr, ',') . '}';
    }

    // Return the field value of the specified id
    private function getFieldValue($id, $default = null, $raw = false) {
      // Get field value
      $val = MCW_MetaBox::get_field_value($this->meta_box_id, $id, $raw);

      // Add filter
      if(has_filter('mcw_fp_field_'.$id)) {
        $val = apply_filters('mcw_fp_field_'.$id, $val);
      }

      // Return field value or default
      return (empty($val) ? $default : $val);
    }

    // Checks if specified setting is on (used for metabox checkboxes) and returns true or false
    private function isFieldEnabled($id) {
      // Get field value
      $val = $this->getFieldValue($id, 'off');

      // Return true if field is on
      if (isset($val) && ($val == 'on')) {
        return true;
      }

      // Return false
      return false;
    }

    // Returns true if the specified field is on
    private function isFieldOn($id) {
      return $this->isFieldEnabled($id) ? 'true' : 'false';
    }

    // Get template file contents
    private function getTemplate($filex, $params) {
      if (file_exists($filex)) {
        extract($params);
        ob_start();
        include($filex);
        return ob_get_clean();
      }

      return '';
    }

    // Get slide navigation css file
    private function getSlideNavFile($section_nav_file) {
      $slide_nav_file = $this->getFieldValue($this->id_SlideNavigationStyle, 'section_nav');
      if ($slide_nav_file == 'section_nav') {
        // Set slide nav style file
        $slide_nav_file = $section_nav_file;
      }
      // TODO: maybe these can be removed in the future
      if ($slide_nav_file == 'crazy-text-effect') {
        $slide_nav_file = 'default';
      }

      return $slide_nav_file;
    }

    // Asset array function
    private function getAsset($folder, $params = array()) {
      // Initialize return value
      $events = array();
      // Check if folder is specified
      if (isset($folder) && !empty($folder)) {
        // Get customization file name
        $file = DIRNAME(__FILE__).'/assets/'.$folder.'/cust.txt';
        // Check if customization file exists
        if (file_exists($file)) {
          // Get customization file contents
          $file = file_get_contents($file);
          // Decode file contents
          $cust = json_decode($file, true);
          // Error handling
          if (isset($cust) && is_array($cust)) {
            // Decode json
            foreach ($cust as $key => $value) {
              // Check if the value exists
              if (isset($value) && !empty($value)) {
                // Get contents
                if (is_array($value)) {
                  // Load contents from file
                  $content_file = '';
                  if (isset($params['file']) && !empty($params['file'])) {
                    $content_file = DIRNAME(__FILE__).'/assets/'.$folder.'/'.$params['file'];
                  }
                  else if (isset($value['file']) && !empty($value['file'])) {
                    // Load contents from file
                    $content_file = DIRNAME(__FILE__).'/assets/'.$folder.'/'.$value['file'];
                  }
                  else {
                    return $events;
                  }

                  // Merge parameters arrays
                  if (isset($value['params'])) {
                    $params = array_merge($value['params'], $params);
                  }

                  // Get template contents
                  $events[$key] = $this->getTemplate($content_file, $params);
                }
                else {
                  $events[$key] = $value;
                }
              }
            }
          }
        }
      }

      return $events;
    }

    // Return specified color code in rgba and hex
    private function getColorCodes($color) {
      $ret = array('hex' => '', 'rgba' => '');

      // Trim input string
      $color = trim($color);

      // Return default if no color provided
      if(empty($color)) {
        return $ret;
      }

      // Sanitize $color if "#" is provided
      if ($color[0] == '#') {
        // Remove first char
        $color = substr($color, 1);

        // Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
          $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        }
        elseif (strlen( $color ) == 3) {
          $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        }
        else {
          return $ret;
        }

        // Convert hexadec to rgb
        $ret['hex'] = '#'.$color;
        $ret['rgba'] = implode(",", array_map('hexdec', $hex));
      }
      else if (substr($color, 0, 4) == 'rgba') {
        $count = preg_match("/^rgba\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*(\d*(?:\.\d+)?)\)$/i", $color, $rgba);

        // Count should be 5 if successfull
        if (count($rgba) == 5) {
          $hex = "#";
          $hex .= str_pad(dechex($rgba[1]), 2, "0", STR_PAD_LEFT);
          $hex .= str_pad(dechex($rgba[2]), 2, "0", STR_PAD_LEFT);
          $hex .= str_pad(dechex($rgba[3]), 2, "0", STR_PAD_LEFT);

          $ret['hex'] = $hex;
          $ret['rgba'] = $rgba[1].','.$rgba[2].','.$rgba[3];
        }
      }
      else if (substr($color, 0, 3) == 'rgb') {
        $count = preg_match("/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/i", $color, $rgb);

        // Count should be 5 if successfull
        if (count($rgba) == 4) {
          $hex = "#";
          $hex .= str_pad(dechex($rgba[1]), 2, "0", STR_PAD_LEFT);
          $hex .= str_pad(dechex($rgba[2]), 2, "0", STR_PAD_LEFT);
          $hex .= str_pad(dechex($rgba[3]), 2, "0", STR_PAD_LEFT);

          $ret['hex'] = $hex;
          $ret['rgba'] = $rgba[1].','.$rgba[2].','.$rgba[3];
        }
      }

      // Return calculated values
      return $ret;
    }

    private function addColorCustomization($file, $selector, $mainColor, $activeColor, $hoverColor) {
      // Create args array
      $args = array();

      // Check if main color is set
      if (!empty($mainColor)) {
        $color = $this->getColorCodes($mainColor);
        $args['color_main_enable'] = 'on';
        $args['main'] = $color['hex'];
        $args['main_rgba'] = $color['rgba'];
      }

      // Check if active color is set
      if (!empty($activeColor)) {
        $color = $this->getColorCodes($activeColor);
        $args['color_active_enable'] = 'on';
        $args['active'] = $color['hex'];
        $args['active_rgba'] = $color['rgba'];
      }

      // Check if hover color is set
      if (!empty($hoverColor)) {
        $color = $this->getColorCodes($hoverColor);
        $args['color_hover_enable'] = 'on';
        $args['hover'] = $color['hex'];
        $args['hover_rgba'] = $color['rgba'];
      }

      if (!empty($args)) {
        // Set filename
        $args['file'] = $file.'.css';
        // Set selector
        $args['selector'] = $selector;
        // Load navigation style with parameters
        $this->customizations[] = $this->getAsset('navigations', $args);
      }
    }

    private function verifyClass($classes, $vcValidClasses) {
      if (isset($classes) && !empty($classes)) {
        foreach( $vcValidClasses as $vcValidClass ) {
          if( preg_match( '/(?<![\S])' . $vcValidClass . '(\s|$)/mUi', $classes ) == 1 ) {
            return true;
          }
        }
      }

      return false;
    }

    private function getRow(DOMDocument $dom, DOMNode $row) {
      $classes = $row->getAttribute('class');

      if ($this->verifyClass($classes, $this->vc_ValidRowClasses)) {
        return $row;
      }

      $elements = array('div', 'section');
      foreach($elements as $element) {
        $nodes = $dom->getElementsByTagName($element);
        foreach( $nodes as $node ) {
          if ($node->nodeType != XML_ELEMENT_NODE)
            continue;

          $classes = $node->getAttribute('class');
          if ($this->verifyClass($classes, $this->vc_ValidRowClasses)) {
            return $node;
          }
        }
      }

			return $row;
    }

    private function getCol($nodes) {
      foreach($nodes as $node) {
        if ($node->nodeType != XML_ELEMENT_NODE) {
          continue;
        }

        $classes = $node->getAttribute('class');
        if ($this->verifyClass($classes, $this->vc_ValidColClasses)) {
          return $nodes;
        }
      }

      $colNodes = null;
      foreach($nodes as $node) {
        if ($node->hasChildNodes()) {
          $colNodes = $this->getCol($node->childNodes);
          if ($colNodes != null) {
            return $colNodes;
          }
        }
      }

      return null;
    }

    // Add fullpage related JS and CSS files
    // Called by wp_enqueue_scripts action
    public function on_wp_enqueue_scripts() {
      global $post;
      if (!isset($post)) {
        return;
      }

      // Check if fullpage is enabled
      if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
        // Put js files to footer
        $isFooter = true;
        // TODO: remove jquery dependency
        $dep = array('jquery');

        // Fullpage CSS
        wp_enqueue_style('mcw_fp_css', plugins_url('fullpage/fullpage.min.css', __FILE__), array(), $this->fullpage_js_version, 'all');

        // Section navigation CSS
        $nav = $this->getFieldValue($this->id_Navigation, 'off');
        $section_nav_file = 'default';
        if ($nav != 'off') {
          $section_nav_file = $this->getFieldValue($this->id_SectionNavigationStyle, 'default');
          wp_enqueue_style( 'mcw_fp_sect_nav_css', plugins_url('fullpage/nav/section/'.$section_nav_file.'.css', __FILE__), array('mcw_fp_css'), $this->fullpage_js_version, 'all' );
        }
        // Slide navigation CSS
        $nav = $this->getFieldValue($this->id_SlideNavigation, 'off');
        if ($nav != 'off') {
          $slide_nav_file = $this->getSlideNavFile($section_nav_file);
          wp_enqueue_style( 'mcw_fp_slide_nav_css', plugins_url('fullpage/nav/slide/'.$slide_nav_file.'.css', __FILE__), array('mcw_fp_css'), $this->fullpage_js_version, 'all' );
        }

        // Add easing js file
        $easing = $this->getFieldValue($this->id_Easing, 'css3_ease');
        if (substr($easing, 0, 3) == 'js_') {
          wp_enqueue_script( 'mcw_fp_easing_js', plugins_url('fullpage/vendors/easings.min.js', __FILE__), array('jquery'), '1.3', $isFooter );
          $dep[] = 'mcw_fp_easing_js';
        }
        // Add scrolloverflow file
        if ( $this->isFieldEnabled($this->id_ScrollOverflow) && !$this->isFieldEnabled($this->id_ScrollBar) ) {
          wp_enqueue_script( 'mcw_fp_iscroll_js', plugins_url('fullpage/vendors/scrolloverflow.min.js', __FILE__), array('jquery'), '0.1.2', $isFooter );
          $dep[] = 'mcw_fp_iscroll_js';
        }

        // Add filter
        if(has_filter('mcw_fp_enqueue')) {
          $dep = apply_filters('mcw_fp_enqueue', $dep, $isFooter);
        }

        // Add fullpage JS file
        if ( $this->isFieldEnabled($this->id_cust_extensions) ) {
          $url = $this->getFieldValue($this->id_cust_extensionUrl, '');
          if (isset($url) && !empty($url)) {
            wp_enqueue_script( 'mcw_fp_js_ext', $url, $dep, $this->fullpage_js_version, $isFooter );
            $dep[] = 'mcw_fp_js_ext';
          }
          wp_enqueue_script( 'mcw_fp_js', plugins_url('fullpage/fullpage.extensions.min.js', __FILE__), $dep, $this->fullpage_js_version, $isFooter );
        }
        else {
          wp_enqueue_script( 'mcw_fp_js', plugins_url('fullpage/fullpage.min.js', __FILE__), $dep, $this->fullpage_js_version, $isFooter );
        }
      }
    }

    // Adds full page enable script to the head
    // Called by wp_head action
    public function on_wp_head() {
      global $post;
      if (!isset($post))
        return;

      // Check if fullpage is enabled
      if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
        // Add global CSS to the customizations
        $section_nav_file = 'default';

        // navigation CSS
        $nav = $this->getFieldValue($this->id_Navigation, 'off');
        if ($nav != 'off') {
          // Section nav file
          $section_nav_file = $this->getFieldValue($this->id_SectionNavigationStyle, 'default');

          // Tooltip CSS
          $tooltipCSS = '';
          // Tooltip background color
          $tooltip = $this->getFieldValue($this->id_TooltipBackground, '');
          if (!empty($tooltip)) {
            $tooltipCSS .= 'padding:0 5px;background-color: '.$tooltip.';';
          }
          // Tooltip text color
          $tooltip = $this->getFieldValue($this->id_TooltipColor, '');
          if (!empty($tooltip)) {
            $tooltipCSS .= 'color: '.$tooltip.';';
          }
          // Add tooltip css to global css
          if (!empty($tooltipCSS)) {
            $this->customizations[] = array(
              'css' => '#fp-nav ul li .fp-tooltip{'.$tooltipCSS.'}'
            );
          }

          $this->addColorCustomization(
            $section_nav_file,
            '#fp-nav',
            $this->getFieldValue($this->id_SectionColor, ''),
            $this->getFieldValue($this->id_SectionActiveColor, ''),
            $this->getFieldValue($this->id_SectionHoverColor, '')
          );
        }

        // slidesNavigation CSS
        $nav = $this->getFieldValue($this->id_SlideNavigation, 'off');
        if ($nav != 'off') {
          $slide_nav_file = $this->getSlideNavFile($section_nav_file);
          // Slide nav is not the same with section style initially
          $slide_nav_section = false;
          // Check if the slide nav style is the same with section style
          if ($this->getFieldValue($this->id_SlideNavigationStyle, 'section_nav') == 'section_nav') {
            // Slide nav is the same with section style
            $slide_nav_section = true;
          }

          // Check if main color is set
          $slideMainColor = $this->getFieldValue($this->id_SlideColor, '');
          if (empty($slideMainColor) && $slide_nav_section) {
            $slideMainColor = $this->getFieldValue($this->id_SectionColor, '');
          }
          // Check if active color is set
          $slideActiveColor = $this->getFieldValue($this->id_SlideActiveColor, '');
          if (empty($slideActiveColor) && $slide_nav_section) {
            $slideActiveColor = $this->getFieldValue($this->id_SectionActiveColor, '');
          }
          // Check if hover color is set
          $slideHoverColor = $this->getFieldValue($this->id_SlideHoverColor, '');
          if (empty($slideHoverColor) && $slide_nav_section) {
            $slideHoverColor = $this->getFieldValue($this->id_SectionHoverColor, '');
          }

          $this->addColorCustomization(
            $slide_nav_file,
            '.fp-slidesNav',
            $slideMainColor,
            $slideActiveColor,
            $slideHoverColor
          );
        }
      }
    }

    // Adds full page js initialization code to the footer if enabled
    // Called by wp_footer action
    public function on_wp_footer() {
      global $post;
      if (!isset($post)) {
        return;
      }

      // Check if fullpage is enabled
      if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
        $fullPageSelector = '.'.$this->an_fullpage;
        // Add fullPage JS initialize code to the footer
        $parameters = array();

        $parameters['licenseKey'] = $this->getValAsString('FE218AD9-CA7948FB-A9A25B87-28826BBE');
        $parameters['lazyLoading'] = 'false'; // TODO: Consider adding an option for this
        // sectionSelector
        $section_selector = $this->getFieldValue($this->id_SectionSelector, $fullPageSelector.'>.' . $this->cn_section);
        $parameters['sectionSelector'] = $this->getValAsString($section_selector);

        // slideSelector
        $str = $this->getFieldValue($this->id_SlideSelector, '.' . $this->cn_slide);
        $parameters['slideSelector'] = $this->getValAsString($str);

        // ****************************************************************************************
        // Navigation parameters
        {
          // navigation, navigationPosition
          $nav = $this->getFieldValue($this->id_Navigation, 'off');
          $parameters['navigation'] = ($nav == 'off') ? 'false' : 'true';
          if ($nav != 'off') {
            // navigationPosition
            $parameters['navigationPosition'] = (($nav == 'right') ? '"right"' : '"left"');
            // showActiveTooltip
            $parameters['showActiveTooltip'] = $this->isFieldOn($this->id_ShowActiveTooltip);
          }

          // slidesNavigation, slidesNavPosition
          $nav = $this->getFieldValue($this->id_SlideNavigation, 'off');
          $parameters['slidesNavigation'] = ($nav == 'off') ? 'false' : 'true';
          if ($nav != 'off') {
            $parameters['slidesNavPosition'] = ($nav == 'top') ? '"top"' : '"bottom"';
          }

          // controlArrows
          $parameters['controlArrows'] = $this->isFieldOn($this->id_ControlArrows);
          // lockAnchors
          $parameters['lockAnchors'] = $this->isFieldOn($this->id_LockAnchors);
          // animateAnchor
          $parameters['animateAnchor'] = $this->isFieldOn($this->id_AnimateAnchor);
          // keyboardScrolling
          $parameters['keyboardScrolling'] = $this->isFieldOn($this->id_KeyboardScrolling);
          // recordHistory
          $parameters['recordHistory'] = $this->isFieldOn($this->id_RecordHistory);
        }

        // ****************************************************************************************
        // Scrolling parameters
        {
          // autoScrolling
          $parameters['autoScrolling'] = $this->isFieldOn($this->id_AutoScrolling);
          // fitToSection
          $parameters['fitToSection'] = $this->isFieldOn($this->id_FitToSection);
          // fitToSectionDelay
          $parameters['fitToSectionDelay'] = $this->getFieldValue($this->id_FitToSectionDelay, '1000');
          // scrollBar
          $parameters['scrollBar'] = $this->isFieldOn($this->id_ScrollBar);

          if ( $this->isFieldEnabled($this->id_ScrollBar) ) {
            $parameters['scrollOverflow'] = 'false';
          } else {
            // scrollOverflow
            $parameters['scrollOverflow'] = $this->isFieldOn($this->id_ScrollOverflow);
            if ( $this->isFieldEnabled($this->id_ScrollOverflow) ) {
              // scrollOverflowOptions
              $scrollOverflowOptions = array(
                'scrollbars' => 'true',
                'fadeScrollbars' => 'false',
                'interactiveScrollbars' => 'false'
              );
              if ( $this->isFieldEnabled($this->id_ScrollOverflowHideScrollbars) ) {
                $scrollOverflowOptions['scrollbars'] = 'false';
              }
              if ( $this->isFieldEnabled($this->id_ScrollOverflowFadeScrollbars) ) {
                $scrollOverflowOptions['fadeScrollbars'] = 'true';
              }
              if ( $this->isFieldEnabled($this->id_ScrollOverflowInteractiveScrollbars) ) {
                $scrollOverflowOptions['interactiveScrollbars'] = 'true';
              }
              $parameters['scrollOverflowOptions'] = $this->implodeParams($scrollOverflowOptions);
            }
          }

          // bigSectionsDestination
          $bigSectionsDestination = $this->getFieldValue($this->id_BigSectionsDestination, 'default');
          if ($bigSectionsDestination != 'default') {
            $parameters['bigSectionsDestination'] = $this->getValAsString($bigSectionsDestination);
          }

          // continuousVertical, loopBottom, loopTop
          if ($this->isFieldEnabled($this->id_ContinuousVertical)) {
            $parameters['continuousVertical'] = 'true';
            $parameters['loopBottom'] = 'false';
            $parameters['loopTop'] = 'false';
          }
          else {
            $parameters['continuousVertical'] = 'false';
            $parameters['loopBottom'] = $this->isFieldOn($this->id_LoopBottom);
            $parameters['loopTop'] = $this->isFieldOn($this->id_LoopTop);
          }

          // loopHorizontal
          $parameters['loopHorizontal'] = $this->isFieldOn($this->id_LoopHorizontal);
          // scrollingSpeed
          $parameters['scrollingSpeed'] = $this->getFieldValue($this->id_ScrollingSpeed, '700');

          // css3, easingcss3, easing
          $easing = $this->getFieldValue($this->id_Easing, 'css3_ease');
          if (substr($easing, 0, 5) == 'css3_') {
            $easing = substr($easing, 5, strlen($easing));
            $parameters['css3'] = 'true';
            $parameters['easingcss3'] = $this->getValAsString($easing);
          }
          else {
            $easing = substr($easing, 3, strlen($easing));
            $parameters['css3'] = 'false';
            $parameters['easing'] = $this->getValAsString($easing);
          }
        }

        // ****************************************************************************************
        // Design parameters
        {
          // verticalCentered
          $parameters['verticalCentered'] = $this->isFieldOn($this->id_VerticalCentered);
          // responsiveWidth
          $parameters['responsiveWidth'] = $this->getFieldValue($this->id_ResponsiveWidth, '0');
          // responsiveHeight
          $parameters['responsiveHeight'] = $this->getFieldValue($this->id_ResponsiveHeight, '0');
          // paddingTop
          $parameters['paddingTop'] = '(typeof mcwPaddingTop!=="undefined")?mcwPaddingTop:' . $this->getValAsString( $this->getFieldValue($this->id_PaddingTop, '0px') );
          // paddingBottom
          $parameters['paddingBottom'] = $this->getValAsString( $this->getFieldValue($this->id_PaddingBottom, '0px') );
          // fixedElements
          $fixed_elements = array_unique(
            array_merge(
              array('.'.$this->cn_fixed_top, '.'.$this->cn_fixed_bottom),
              array_filter( explode( ',', $this->getFieldValue($this->id_FixedElements, '') ) )
            )
          );
          $parameters['fixedElements'] = $this->getValAsString( implode(',', $fixed_elements) );
          // normalScrollElements
          $normalScrollElements = $this->getFieldValue($this->id_NormalScrollElements, '');
          if (isset($normalScrollElements) && !empty($normalScrollElements)) {
            $parameters['normalScrollElements'] = $this->getValAsString($normalScrollElements);
          }
        }

        // ****************************************************************************************
        // Customization on events
        {
          $this->customizations[] = $this->getAsset('musthave', array('parent' => '.' . $this->an_fullpage, 'sectionClass' => $this->cn_section));

          $this->customizations[] = array(
            'css' => '.fp-sr-only{visibility:hidden}'
          );

          // VC animations customization
          if ( $this->isFieldEnabled($this->id_cust_enableVCAnim) ) {
            $this->customizations[] = $this->getAsset('vc_anim');
            if ( $this->isFieldEnabled($this->id_cust_enableVCAnimReset) ) {
              $this->customizations[] = $this->getAsset('vc_anim_reset');
            }
          }
          // Force remove margins customization
          if ( $this->isFieldEnabled($this->id_cust_forceRemoveThemeMargins) ) {
            $this->customizations[] = $this->getAsset('theme_remove_margins');
          }
          // Video autoplay customization
          if ( $this->isFieldEnabled($this->id_cust_videoautoplay) ) {
            $this->customizations[] = $this->getAsset('video_autoplay', array('selector' => $section_selector));
          }
          // Force fixed theme header
          if ( $this->isFieldEnabled($this->id_cust_forceFixedThemeHeader) ) {
            $sel = $this->getFieldValue($this->id_cust_forceFixedThemeHeaderSelector, 'header');
            if (!empty($sel)) {
              $this->customizations[] = $this->getAsset('theme_header_fixed', array('header' => $sel, 'selector' => $section_selector));
            }
          }
          // Page Builder Container Fix
          if ( $this->isFieldEnabled($this->id_cust_pbContainerFix) ) {
            $sel = $this->getFieldValue($this->id_cust_pbContainerSelector, '.container-wrap,.vc-row-container,.ia_row');
            //if (!empty($sel)) {
              $this->customizations[] = $this->getAsset('pb_container_fix', array('parent' => '.' . $this->an_fullpage, 'section' => '.' . $this->cn_section, 'container' => $sel));
            //}
          }
        }

        $before_fullpage = '';
        $after_fullpage = '';

        // ****************************************************************************************
        // Default event function codes
        {
          $events_default = array(
            'afterLoad' => 'function(origin, destination, direction){}',
            'onLeave' => 'function(origin, destination, direction){}',
            'afterRender' => 'function(){}',
            'afterResize' => 'function(width, height){}',
            'afterSlideLoad' => 'function( section, origin, destination, direction){}',
            'onSlideLeave' => 'function( section, origin, destination, direction){}',
            'afterResponsive' => 'function(isResponsive){}',
          );

          // afterLoad event
          if ( $this->isFieldEnabled($this->id_afterLoadEnable) ) {
            $parameters['afterLoad'] = $this->getFieldValue($this->id_evt_afterLoad, $events_default['afterLoad'], true);
          }
          // onLeave event
          if ( $this->isFieldEnabled($this->id_onLeaveEnable) ) {
            $parameters['onLeave'] = $this->getFieldValue($this->id_evt_onLeave, $events_default['onLeave'], true);
          }
          // afterRender event
          if ( $this->isFieldEnabled($this->id_afterRenderEnable) ) {
            $parameters['afterRender'] = $this->getFieldValue($this->id_evt_afterRender, $events_default['afterRender'], true);
          }
          // afterResize event
          if ( $this->isFieldEnabled($this->id_afterResizeEnable) ) {
            $parameters['afterResize'] = $this->getFieldValue($this->id_evt_afterResize, $events_default['afterResize'], true);
          }
          // afterSlideLoad event
          if ( $this->isFieldEnabled($this->id_afterSlideLoadEnable) ) {
            $parameters['afterSlideLoad'] = $this->getFieldValue($this->id_evt_afterSlideLoad, $events_default['afterSlideLoad'], true);
          }
          // onSlideLeave event
          if ( $this->isFieldEnabled($this->id_onSlideLeaveEnable) ) {
            $parameters['onSlideLeave'] = $this->getFieldValue($this->id_evt_onSlideLeave, $events_default['onSlideLeave'], true);
          }
          // afterResponsive event
          if ( $this->isFieldEnabled($this->id_afterresponsive) ) {
            $parameters['afterResponsive'] = $this->getFieldValue($this->id_evt_afterresponsive, $events_default['afterResponsive'], true);
          }
          // beforeFullPage event
          if ( $this->isFieldEnabled($this->id_beforefullpage) ) {
            $before_fullpage = $this->getFieldValue($this->id_evt_beforefullpage, '', true);
          }
          // afterFullPage event
          if ( $this->isFieldEnabled($this->id_afterfullpage) ) {
            $after_fullpage = $this->getFieldValue($this->id_evt_afterfullpage, '', true);
          }
        }

        // ****************************************************************************************
        // Customization code
        $css = '.fp-section {margin:0 !important;opacity:1 !important}';
        if (!empty($this->customizations)) {
          foreach ($this->customizations as $events) {
            if (!empty($events)) {
              foreach ($events as $key => $js) {
                switch ($key) {
                  case 'before':
                    $before_fullpage = $js.$before_fullpage;
                    break;

                  case 'after':
                    $after_fullpage = $js.$after_fullpage;
                    break;

                  case 'css':
                    $css .= $js;
                    break;

                  default:
                    if (isset($parameters[$key])) {
                      // Add js after the bracket
                      $parameters[$key] = substr_replace($parameters[$key], $js, strpos($parameters[$key], "{") + 1, 0);
                    }
                    else {
                      $parameters[$key] = substr_replace($events_default[$key], $js, strpos($events_default[$key], "{") + 1, 0);
                    }
                    break;
                }
              }
            }
          }
        }

        // Add filter
        if(has_filter('mcw_fp_parameters')) {
          $parameters = apply_filters('mcw_fp_parameters', $parameters);
        }

        // Extra parameters
        $extras = $this->getFieldValue($this->id_ExtraParameters, '');

        // Echo CSS
        echo '<style type="text/css">'.$css.'</style>';
        // Output script
        echo '<script type="text/javascript">(function($){"use strict";' .
          $before_fullpage .
          'new fullpage("' .
          $fullPageSelector .
          '", ' . $this->implodeParams($parameters, $extras) . ');' .
          $after_fullpage .
          '})(jQuery);</script>';
      }
    }

    // Adds full page wrapper to the content
    // Called by the_content filter
    public function on_the_content($content) {
      // Check if fullpage is enabled
      if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
        // Add full page div wrapper
        $content = '<div id="'.$this->an_fullpage.'" class="'. $this->an_fullpage .'">'.$content.'</div>';
      }
      // Return full page content
      return $content;
    }

    // Called by template_redirect action
    public function on_template_redirect() {
      global $post;
      if (!isset($post)) {
        return;
      }

      // Check if fullpage is enabled
      if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
        // Check if template is enabled
        if ( $this->isFieldEnabled($this->id_EnableTemplate) ) {
          // Check if template redirect is enabled
          if ( $this->isFieldEnabled($this->id_TemplateRedirect) ) {
            $path = trim( $this->getFieldValue($this->id_TemplatePath, '') );

            if ($path == '') {
              $path = plugin_dir_path(__FILE__).'template/mcw_fullpage_template.php';
            }

            // Add filter
            if(has_filter('mcw_fp_template')) {
              $path = apply_filters('mcw_fp_template', $path);
            }

            if (!empty($path)) {
              include($path);
              exit();
            }
          }
        }
      }
    }

    // Called by template_include filter
    public function on_template_include($original_template) {
      global $post;
      if (!isset($post)) {
        return $original_template;
      }

      // Check if fullpage is enabled
      if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
        // Check if template is enabled
        if ( $this->isFieldEnabled($this->id_EnableTemplate) ) {
          // Check if template redirect is disabled
          if ( $this->isFieldEnabled($this->id_TemplateRedirect) == false ) {
            $path = trim( $this->getFieldValue($this->id_TemplatePath, '') );

            if ($path == '') {
              $path = plugin_dir_path(__FILE__).'template/mcw_fullpage_template.php';
            }

            // Add filter
            if(has_filter('mcw_fp_template')) {
              $path = apply_filters('mcw_fp_template', $path);
            }

            if (!empty($path)) {
              return $path;
            }
          }
        }
      }

      return $original_template;
    }

    // Remove unwanted JS from header
    // Called by wp_print_scripts action
    public function on_wp_print_scripts() {
      // Get post
      global $post;
      // Get global scripts
      global $wp_scripts;

      if (!isset($post))
        return;

      // Check if fullpage is enabled
      if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
        // Check if remove theme js is enabled
        if ( $this->isFieldEnabled($this->id_RemoveThemeJS) ) {
          // Error handling
          if (isset($wp_scripts) && isset($wp_scripts->registered)) {
            // Get theme URL
            $themeUrl = get_bloginfo('template_directory');

            // Remove theme related scripts
            foreach ($wp_scripts->registered as $key=>$script) {
              if (isset($script->src)) {
                if (stristr($script->src, $themeUrl) !== false) {
                  // Remove theme js
                  unset($wp_scripts->registered[$key]);
                  // Remove from queue
                  if (isset($wp_scripts->queue)) {
                    $wp_scripts->queue = array_diff($wp_scripts->queue, array($key));
                    $wp_scripts->queue = array_values($wp_scripts->queue);
                  }
                }
              }
            }
          }
        }

        // Check if remove js is enabled
        $removeJS = array_filter( explode( ',', $this->getFieldValue($this->id_RemoveJS, '') ) );
        if ( isset($removeJS) && is_array($removeJS) && !empty($removeJS) ) {
          // Error handling
          if (isset($wp_scripts) && isset($wp_scripts->registered)) {
            // Remove scripts
            foreach ($wp_scripts->registered as $key=>$script) {
              if (isset($script->src)) {
                foreach ($removeJS as $remove) {
                  if (!isset($remove)) {
                    continue;
                  }
                  // Trim js
                  $remove = trim($remove);
                  // Check if script includes the removed JS
                  if (stristr($script->src, $remove) !== false) {
                    // Remove js
                    unset($wp_scripts->registered[$key]);
                    // Remove from queue
                    if (isset($wp_scripts->queue)) {
                      $wp_scripts->queue = array_diff($wp_scripts->queue, array($key));
                      $wp_scripts->queue = array_values($wp_scripts->queue);
                    }
                  }
                }
              }
            }
          }
        }
      }
    }

    // Called by body_class filter
    public function on_body_class($classes) {
      // Check if fullpage is enabled
      if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
        // Add big navigation styles class
        if ( $this->isFieldEnabled($this->id_BigSectionNavigation) ) {
          $classes[] = 'fp-big-nav';
        }
        if ( $this->isFieldEnabled($this->id_BigSlideNavigation) ) {
          $classes[] = 'fp-big-slide-nav';
        }
      }
      return $classes;
    }

    // Change shortcode output if nececssary
    // Called by vc_shortcode_output filter
    public function on_vc_shortcode_output($output, $obj, $atts) {
      // Full page enabled, so add a full page wrapper
      if ( $obj->settings('base')=='vc_row' ) {
        // Check if fullpage is enabled
        if ( $this->isFieldEnabled($this->id_fullPageEnable) ) {
          if ($output === '') {
            return $output;
          }

          // Check if row is disabled
          if ( isset($atts['disable_element']) && ($atts['disable_element'] == 'yes') ) {
            return $output;
          }

          if ( !function_exists( 'libxml_use_internal_errors' ) ) {
            return $output;
          }

          // Create a new dom document and load the ouput
          $dom = new DOMDocument('1.1');
          // Prevent entity errors
          $libxml_prev = libxml_use_internal_errors(true);

          if ( function_exists( 'mb_convert_encoding' ) && function_exists( 'mb_detect_encoding' ) ) {
            $charset = mb_detect_encoding($output);
            $output = mb_convert_encoding($output, 'HTML-ENTITIES', $charset);
          }

          $dom->loadHTML($output);
          // Get the actual row
          $row = $this->getRow($dom, $dom->documentElement->firstChild->childNodes->item( 0 ) );
          // Initialize fullpage classes
          $fpClasses = '';
          // Check if fixed top is on
          if ((isset($atts[$this->vc_SectionBehaviour])) && ($atts[$this->vc_SectionBehaviour] == 'fixed_top')) {
            $fpClasses = $this->cn_fixed_top;
          }
          // Check if fixed top is on
          else if ( (isset($atts[$this->vc_SectionBehaviour])) && ($atts[$this->vc_SectionBehaviour] == 'fixed_bottom') ) {
            $fpClasses = $this->cn_fixed_bottom;
          }
          else{
            $fpClasses = $this->cn_section;
            // Disable scrollbars if checked
            if ( (isset($atts[$this->vc_NoScrollbar])) && ($atts[$this->vc_NoScrollbar] == 'true') ) {
              $fpClasses .= ' fp-noscroll';
            }

            // Check if autoheight is on
            if ( (isset($atts[$this->vc_SectionBehaviour])) && ($atts[$this->vc_SectionBehaviour] == 'on') ) {
              $fpClasses .= ' fp-auto-height';
            }

            // Check if responsive autoheight is on
            if ( (isset($atts[$this->vc_SectionBehaviour])) && ($atts[$this->vc_SectionBehaviour] == 'responsive') ) {
              $fpClasses .= ' fp-auto-height-responsive';
            }
          }

          // Add class names
          if (!empty($fpClasses)) {
            // Get row classes
            $classes = $row->getAttribute('class');
            $row->setAttribute('class', $classes . ' ' . $fpClasses);
          }

          // Add data anchor
          $anchor = 'section'.$this->vc_RowCounter;
          $this->vc_RowCounter++;
          if ( isset($atts[$this->vc_Anchor]) && !empty($atts[$this->vc_Anchor]) ) {
            $anchor = preg_replace('/\s+/', '_', $atts[$this->vc_Anchor]);
          }
          $row->setAttribute('data-anchor', $anchor);

          // Add data tooltip
          if ( isset($atts[$this->vc_Tooltip]) && !empty($atts[$this->vc_Tooltip]) ) {
            $row->setAttribute('data-tooltip', $atts[$this->vc_Tooltip]);
          }

          // Set slide anchor
          if ( (isset($atts[$this->vc_ColumnSlides])) && ($atts[$this->vc_ColumnSlides] == 'true') ) {
            if ($row->hasChildNodes()) {
              $colNodes = $this->getCol($row->childNodes);
              if ( isset($colNodes) && ($colNodes != null) ) {
                foreach ($colNodes as $node) {
                  if ($node->nodeType != XML_ELEMENT_NODE) {
                    continue;
                  }
                  $classes = $node->getAttribute('class');
                  $node->setAttribute('class', $classes . ' ' . $this->cn_slide);
                }
              }
            }
          }

          // Save output html
          $output = $dom->saveHTML();
          preg_match( "/<body>([\S|.|\s]*)<\/body>/mU", $output, $matches );
          if(isset($matches[1])) {
            $output = $matches[1];
          }
          $output = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $output), ENT_NOQUOTES, 'UTF-8');

          // Clear libxml errors and restore internal errors
          libxml_clear_errors();
          libxml_use_internal_errors($libxml_prev);

          // Add customizations for the row
          $section_nav_file = 'default';
          $nav = $this->getFieldValue($this->id_Navigation, 'off');
          if ($nav != 'off') {
            $section_nav_file = $this->getFieldValue($this->id_SectionNavigationStyle, 'default');

            $this->addColorCustomization(
              $section_nav_file,
              'body[class*="fp-viewing-'.$anchor.'"] #fp-nav',
              isset($atts[$this->vc_SectionMainColor]) ? $atts[$this->vc_SectionMainColor] : '',
              isset($atts[$this->vc_SectionActiveColor]) ? $atts[$this->vc_SectionActiveColor] : '',
              isset($atts[$this->vc_SectionHoverColor]) ? $atts[$this->vc_SectionHoverColor] : ''
            );
          }

          $nav = $this->getFieldValue($this->id_SlideNavigation, 'off');
          if ($nav != 'off') {
            $slide_nav_file = $this->getSlideNavFile($section_nav_file);

            $this->addColorCustomization(
              $slide_nav_file,
              'body[class*="fp-viewing-'.$anchor.'"] .fp-slidesNav',
              isset($atts[$this->vc_SectionMainColor]) ? $atts[$this->vc_SectionMainColor] : '',
              isset($atts[$this->vc_SectionActiveColor]) ? $atts[$this->vc_SectionActiveColor] : '',
              isset($atts[$this->vc_SectionHoverColor]) ? $atts[$this->vc_SectionHoverColor] : ''
            );
          }

          if (!array_key_exists($this->cn_fixed_top, $this->customizations)) {
            // Check row if fixed top
            if ( isset($atts[$this->vc_SectionBehaviour]) && (trim($atts[$this->vc_SectionBehaviour]) == 'fixed_top') ) {
              $this->customizations[$this->cn_fixed_top] = array(
                'css' => '.'.$this->cn_fixed_top.'{position: fixed !important; z-index: 999999; top: 0px; width: 100%;}'
              );
            }
          }

          if (!array_key_exists($this->cn_fixed_bottom, $this->customizations)) {
            // Check row if fixed bottom
            if ( isset($atts[$this->vc_SectionBehaviour]) && (trim($atts[$this->vc_SectionBehaviour]) == 'fixed_bottom') ) {
              $this->customizations[$this->cn_fixed_top] = array(
                'css' => '.'.$this->cn_fixed_bottom.'{position: fixed !important; z-index: 999999; bottom: 0px; width: 100%;}'
              );
            }
          }
        }
      }

      // Return output
      return $output;
    }

    // Creates full page meta box with parameters
    protected function init_meta_box() {
      // Check if meta box class exists
      if (!class_exists('MCW_MetaBox')) {
        return;
      }

      // Get WPBakery Page Builder active post types
      if (function_exists('vc_editor_post_types')) {
        $post_types = vc_editor_post_types();
      }
      // Check if it is empty
      if (empty($post_types)) {
        $post_types = array('page');
      }

      // Add filter
      if(has_filter('mcw_fp_post_types')) {
        $post_types = apply_filters('mcw_fp_post_types', $post_types);
      }

      // Enable full page section
      $full_page_enable_section = array(
        'type' => 'section',
        'fields' => array(
          array(
            'label' => $this->translate('Enable Full Page'),
            'id' => $this->id_fullPageEnable,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter enables full page on this post.'),
          ),
        ),
      );

      // Navigation accordion
      // TODO: Missing fields
      // menu
      $nav_accordion_fields = array(
        'title' => $this->translate('Navigation'),
        'type' => 'accordion',
        'dependency' => array( array('controller' => $this->id_fullPageEnable, 'condition' => '==', 'value' => true) ),
        'fields' => array(
          // navigation, navigationPosition
          array(
            'label' => $this->translate('Section Navigation'),
            'id' => $this->id_Navigation,
            'type' => 'selectbox',
            'options' => array(
              'off' => $this->translate('Off'),
              'left' => $this->translate('Left'),
              'right' => $this->translate('Right'),
            ),
            'value' => 'off',
            'description' => $this->translate('This parameter determines the position of navigation bar.'),
          ),
          // Section Navigation Style
          array(
            'label' => $this->translate('Section Navigation Style'),
            'id' => $this->id_SectionNavigationStyle,
            'type' => 'selectbox',
            'options' => array(
              'default' => $this->translate('Default'),
              'circles' => $this->translate('Circles'),
              'circles-inverted' => $this->translate('Circles Inverted'),
              'expanding-circles' => $this->translate('Expanding Circles'),
              'filled-circles' => $this->translate('Filled Circles'),
              'filled-circle-within' => $this->translate('Filled Circles Within'),
              'multiple-circles' => $this->translate('Multiple Circles'),
              'rotating-circles' => $this->translate('Rotating Circles'),
              'rotating-circles2' => $this->translate('Rotating Circles 2'),
              'squares' => $this->translate('Squares'),
              'squares-border' => $this->translate('Squares Border'),
              'expanding-squares' => $this->translate('Expanding Squares'),
              'filled-squares' => $this->translate('Filled Squares'),
              'multiple-squares' => $this->translate('Multiple Squares'),
              'squares-to-rombs' => $this->translate('Squares to Rombs'),
              'multiple-squares-to-rombs' => $this->translate('Multiple Squares to Rombs'),
              'filled-rombs' => $this->translate('Filled Rombs'),
              'filled-bars' => $this->translate('Filled Bars'),
              'story-telling' => $this->translate('Story Telling'),
              'crazy-text-effect' => $this->translate('Crazy Text Effect'),
            ),
            'value' => 'default',
            'dependency' => array( array('controller' => $this->id_Navigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter determines section navigation style.'),
          ),
          // Main color
          array(
            'label' => $this->translate('Main Color'),
            'id' => $this->id_SectionColor,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_Navigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter sets the color of bullets on sections. Leave empty for the default color. (Only hex colors such as #DD3333)'),
          ),
          // Hover color
          array(
            'label' => $this->translate('Hover Color'),
            'id' => $this->id_SectionHoverColor,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_Navigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter sets the hover color of bullets on sections. This color may not be used in some of the navigation styles.  Leave empty for the default color. (Only hex colors such as #DD3333)'),
          ),
          // Active color
          array(
            'label' => $this->translate('Active Color'),
            'id' => $this->id_SectionActiveColor,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_Navigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter sets the active color of bullets on sections. This color may not be used in some of the navigation styles.  Leave empty for the default color. (Only hex colors such as #DD3333)'),
          ),
          // tooltipBackground
          array(
            'label' => $this->translate('Tooltip Background Color'),
            'id' => $this->id_TooltipBackground,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_Navigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('The background color of the navigation tooltip. (example: #e5e5e5 or rgba(229, 229, 229, 0.5))'),
          ),
          // tooltipColor
          array(
            'label' => $this->translate('Tooltip Text Color'),
            'id' => $this->id_TooltipColor,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_Navigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('The text color of the navigation tooltip. (example: #000000)'),
          ),
          // showActiveTooltip
          array(
            'label' => $this->translate('Show Active Tooltip'),
            'id' => $this->id_ShowActiveTooltip,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_Navigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter shows a persistent tooltip for the actively viewed section in the vertical navigation.'),
          ),
          // big navigation styles
          array(
            'label' => $this->translate('Bigger Navigation'),
            'id' => $this->id_BigSectionNavigation,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_Navigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter sets bigger navigation bullets.'),
          ),
          // slidesNavigation, slidesNavPosition
          array(
            'label' => $this->translate('Slides Navigation'),
            'id' => $this->id_SlideNavigation,
            'type' => 'selectbox',
            'options' => array(
              'off' => $this->translate('Off'),
              'top' => $this->translate('Top'),
              'bottom' => $this->translate('Bottom'),
            ),
            'value' => 'off',
            'description' => $this->translate('This parameter determines the position of landscape navigation bar for sliders.'),
          ),
          // Slide Navigation Style
          array(
            'label' => $this->translate('Slide Navigation Style'),
            'id' => $this->id_SlideNavigationStyle,
            'type' => 'selectbox',
            'options' => array(
              'section_nav' => $this->translate('Same with Section Navigation Style'),
              'default' => $this->translate('Default'),
              'circles' => $this->translate('Circles'),
              'circles-inverted' => $this->translate('Circles Inverted'),
              'expanding-circles' => $this->translate('Expanding Circles'),
              'filled-circles' => $this->translate('Filled Circles'),
              'filled-circle-within' => $this->translate('Filled Circles Within'),
              'multiple-circles' => $this->translate('Multiple Circles'),
              'rotating-circles' => $this->translate('Rotating Circles'),
              'rotating-circles2' => $this->translate('Rotating Circles 2'),
              'squares' => $this->translate('Squares'),
              'squares-border' => $this->translate('Squares Border'),
              'expanding-squares' => $this->translate('Expanding Squares'),
              'filled-squares' => $this->translate('Filled Squares'),
              'multiple-squares' => $this->translate('Multiple Squares'),
              'squares-to-rombs' => $this->translate('Squares to Rombs'),
              'multiple-squares-to-rombs' => $this->translate('Multiple Squares to Rombs'),
              'filled-rombs' => $this->translate('Filled Rombs'),
              'filled-bars' => $this->translate('Filled Bars'),
            ),
            'value' => 'default',
            'dependency' => array( array('controller' => $this->id_SlideNavigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter determines section navigation style.'),
          ),
          // Main color
          array(
            'label' => $this->translate('Main Color'),
            'id' => $this->id_SlideColor,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_SlideNavigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter sets the color of bullets on slides. Leave empty for the default color. (Only hex colors such as #DD3333)'),
          ),
          // Hover color
          array(
            'label' => $this->translate('Hover Color'),
            'id' => $this->id_SlideHoverColor,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_SlideNavigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter sets the hover color of bullets on slides. This color may not be used in some of the navigation styles. Leave empty for the default color. (Only hex colors such as #DD3333)'),
          ),
          // Active color
          array(
            'label' => $this->translate('Active Color'),
            'id' => $this->id_SlideActiveColor,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_SlideNavigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter sets the active color of bullets on slides. This color may not be used in some of the navigation styles. Leave empty for the default color. (Only hex colors such as #DD3333)'),
          ),
          // big navigation styles
          array(
            'label' => $this->translate('Bigger Slide Navigation'),
            'id' => $this->id_BigSlideNavigation,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_SlideNavigation, 'condition' => '!=', 'value' => 'off') ),
            'level' => '1',
            'description' => $this->translate('This parameter sets bigger slide navigation bullets.'),
          ),
          // controlArrows
          array(
            'label' => $this->translate('Control Arrows'),
            'id' => $this->id_ControlArrows,
            'type' => 'checkbox',
            'value' => 'on',
            'description' => $this->translate('This parameter determines whether to use control arrows for the slides to move right or left.'),
          ),
          // lockAnchors
          array(
            'label' => $this->translate('Lock Anchors'),
            'id' => $this->id_LockAnchors,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter determines whether anchors in the URL will have any effect.'),
          ),
          // animateAnchor
          array(
            'label' => $this->translate('Animate Anchor'),
            'id' => $this->id_AnimateAnchor,
            'type' => 'checkbox',
            'value' => 'on',
            'description' => $this->translate('This parameter defines whether the load of the site when given anchor (#) will scroll with animation to its destination.'),
          ),
          // keyboardScrolling
          array(
            'label' => $this->translate('Keyboard Scrolling'),
            'id' => $this->id_KeyboardScrolling,
            'type' => 'checkbox',
            'value' => 'on',
            'description' => $this->translate('This parameter defines if the content can be navigated using the keyboard.'),
          ),
          // recordHistory
          array(
            'label' => $this->translate('Record History'),
            'id' => $this->id_RecordHistory,
            'type' => 'checkbox',
            'value' => 'on',
            'description' => $this->translate('This parameter defines whether to push the state of the site to the browsers history, so back button will work on section navigation.'),
          ),
        ),
      );

      // Scrolling accordion
      // TODO: Missing fields
      // touchSensitivity
      // normalScrollElementTouchThreshold
      $scrolling_accordion_fields = array(
        'title' => $this->translate('Scrolling'),
        'type' => 'accordion',
        'dependency' => array( array('controller' => $this->id_fullPageEnable, 'condition' => '==', 'value' => true) ),
        'fields' => array(
          // autoScrolling
          array(
            'label' => $this->translate('Auto Scrolling'),
            'id' => $this->id_AutoScrolling,
            'type' => 'checkbox',
            'value' => 'on',
            'description' => $this->translate('This parameter defines whether to use the automatic scrolling or the normal one.'),
          ),
          // fitToSection
          array(
            'label' => $this->translate('Fit To Section'),
            'id' => $this->id_FitToSection,
            'type' => 'checkbox',
            'value' => 'on',
            'description' => $this->translate('This parameter determines whether or not to fit sections to the viewport or not.'),
          ),
          // fitToSectionDelay
          array(
            'label' => $this->translate('Fit To Section Delay'),
            'id' => $this->id_FitToSectionDelay,
            'type' => 'textbox',
            'value' => '1000',
            'level' => '1',
            'dependency' => array( array('controller' => $this->id_FitToSection, 'condition' => '==', 'value' => true) ),
            'description' => $this->translate('The delay in miliseconds for section fitting.'),
          ),
          // scrollBar
          array(
            'label' => $this->translate('Scroll Bar'),
            'id' => $this->id_ScrollBar,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter determines whether to use the scrollbar for the site or not.'),
          ),
          // scrollOverflow
          array(
            'label' => $this->translate('Scroll Overflow'),
            'id' => $this->id_ScrollOverflow,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter defines whether or not to create a scroll for the section in case the content is bigger than the height of it. (Disabled when Scrollbars are enabled.)'),
          ),
          // scrollOverflow / scrollbars
          array(
            'label' => $this->translate('Hide Scrollbars'),
            'id' => $this->id_ScrollOverflowHideScrollbars,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_ScrollOverflow, 'condition' => '==', 'value' => true) ),
            'level' => '1',
            'description' => $this->translate('This parameter hides scrollbar even if the scrolling is enabled inside the sections.'),
          ),
          // scrollOverflow / fadeScrollbars
          array(
            'label' => $this->translate('Fade Scrollbars'),
            'id' => $this->id_ScrollOverflowFadeScrollbars,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_ScrollOverflow, 'condition' => '==', 'value' => true) ),
            'level' => '1',
            'description' => $this->translate('This parameter fades scrollbar when unused.'),
          ),
          // scrollOverflow / interactive scrollbars
          array(
            'label' => $this->translate('Interactive Scrollbars'),
            'id' => $this->id_ScrollOverflowInteractiveScrollbars,
            'type' => 'checkbox',
            'value' => 'on',
            'dependency' => array( array('controller' => $this->id_ScrollOverflow, 'condition' => '==', 'value' => true) ),
            'level' => '1',
            'description' => $this->translate('This parameter makes scrollbar draggable and user can interact with it.'),
          ),
          // bigSectionsDestination
          array(
            'label' => $this->translate('Big Sections Destination'),
            'id' => $this->id_BigSectionsDestination,
            'type' => 'selectbox',
            'options' => array(
              'default' => $this->translate('Default'),
              'top' => $this->translate('Top'),
              'bottom' => $this->translate('Bottom'),
            ),
            'value' => 'default',
            'description' => $this->translate('This parameter defines how to scroll to a section which size is bigger than the viewport.'),
          ),
          // continuousVertical
          array(
            'label' => $this->translate('Continuous Vertical'),
            'id' => $this->id_ContinuousVertical,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter determines vertical scrolling is continuous.'),
          ),
          // loopBottom
          array(
            'label' => $this->translate('Loop Bottom'),
            'id' => $this->id_LoopBottom,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_ContinuousVertical, 'condition' => '==', 'value' => false) ),
            'level' => '1',
            'description' => $this->translate('This parameter determines whether to use the scrollbar for the site or not.'),
          ),
          // loopTop
          array(
            'label' => $this->translate('Loop Top'),
            'id' => $this->id_LoopTop,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_ContinuousVertical, 'condition' => '==', 'value' => false) ),
            'level' => '1',
            'description' => $this->translate('This parameter determines whether to use the scrollbar for the site or not.'),
          ),

          // loopHorizontal
          array(
            'label' => $this->translate('Loop Slides'),
            'id' => $this->id_LoopHorizontal,
            'type' => 'checkbox',
            'value' => 'on',
            'description' => $this->translate('This parameter defines whether horizontal sliders will loop after reaching the last or previous slide or not.'),
          ),
          // css3, easingcss3, easing
          array(
            'label' => $this->translate('Easing'),
            'id' => $this->id_Easing,
            'type' => 'selectbox',
            'options' => array(
              'css3_ease' => $this->translate('CSS3 - Ease'),
              'css3_linear' => $this->translate('CSS3 - Linear'),
              'css3_ease-in' => $this->translate('CSS3 - Ease In'),
              'css3_ease-out' => $this->translate('CSS3 - Ease Out'),
              'css3_ease-in-out' => $this->translate('CSS3 - Ease In Out'),
              'js_linear' => $this->translate('Linear'),
              'js_swing' => $this->translate('Swing'),
              'js_easeInQuad' => $this->translate('Ease In Quad'),
              'js_easeOutQuad' => $this->translate('Ease Out Quad'),
              'js_easeInOutQuad' => $this->translate('Ease In Out Quad'),
              'js_easeInCubic' => $this->translate('Ease In Cubic'),
              'js_easeOutCubic' => $this->translate('Ease Out Cubic'),
              'js_easeInOutCubic' => $this->translate('Ease In Out Cubic'),
              'js_easeInQuart' => $this->translate('Ease In Quart'),
              'js_easeOutQuart' => $this->translate('Ease Out Quart'),
              'js_easeInOutQuart' => $this->translate('Ease In Out Quart'),
              'js_easeInQuint' => $this->translate('Ease In Quint'),
              'js_easeOutQuint' => $this->translate('Ease Out Quint'),
              'js_easeInOutQuint' => $this->translate('Ease In Out Quint'),
              'js_easeInExpo' => $this->translate('Ease In Expo'),
              'js_easeOutExpo' => $this->translate('Ease Out Expo'),
              'js_easeInOutExpo' => $this->translate('Ease In Out Expo'),
              'js_easeInSine' => $this->translate('Ease In Sine'),
              'js_easeOutSine' => $this->translate('Ease Out Sine'),
              'js_easeInOutSine' => $this->translate('Ease In Out Sine'),
              'js_easeInCirc' => $this->translate('Ease In Circ'),
              'js_easeOutCirc' => $this->translate('Ease Out Circ'),
              'js_easeInOutCirc' => $this->translate('Ease In Out Circ'),
              'js_easeInElastic' => $this->translate('Ease In Elastic'),
              'js_easeOutElastic' => $this->translate('Ease Out Elastic'),
              'js_easeInOutElastic' => $this->translate('Ease In Out Elastic'),
              'js_easeInBack' => $this->translate('Ease In Back'),
              'js_easeOutBack' => $this->translate('Ease Out Back'),
              'js_easeInOutBack' => $this->translate('Ease In Out Back'),
              'js_easeInBounce' => $this->translate('Ease In Bounce'),
              'js_easeOutBounce' => $this->translate('Ease Out Bounce'),
              'js_easeInOutBounce' => $this->translate('Ease In Out Bounce'),
            ),
            'value' => 'css3_ease',
            'description' => $this->translate('This parameter determines the transition effect.'),
          ),
          // scrollingSpeed
          array(
            'label' => $this->translate('Scrolling Speed'),
            'id' => $this->id_ScrollingSpeed,
            'type' => 'textbox',
            'value' => '700',
            'description' => $this->translate('Speed in miliseconds for the scrolling transitions.'),
          ),
        ),
      );

      // Design accordion
      $design_accordion_fields = array(
        'title' => $this->translate('Design'),
        'type' => 'accordion',
        'dependency' => array( array('controller' => $this->id_fullPageEnable, 'condition' => '==', 'value' => true) ),
        'fields' => array(
          // verticalCentered
          array(
            'label' => $this->translate('Vertically Centered'),
            'id' => $this->id_VerticalCentered,
            'type' => 'checkbox',
            'value' => 'on',
            'description' => $this->translate('This parameter determines whether to center the content vertically.'),
          ),
          // responsiveWidth
          array(
            'label' => $this->translate('Responsive Width'),
            'id' => $this->id_ResponsiveWidth,
            'type' => 'textbox',
            'value' => '0',
            'description' => $this->translate('Normal scroll will be used under the defined width in pixels. (autoScrolling: false)'),
          ),
          // responsiveHeight
          array(
            'label' => $this->translate('Responsive Height'),
            'id' => $this->id_ResponsiveHeight,
            'type' => 'textbox',
            'value' => '0',
            'description' => $this->translate('Normal scroll will be used under the defined height in pixels. (autoScrolling: false)'),
          ),
          // paddingTop
          array(
            'label' => $this->translate('Padding Top'),
            'id' => $this->id_PaddingTop,
            'type' => 'textbox',
            'value' => '0px',
            'description' => $this->translate('Defines top padding for each section. Useful in case of using fixed header. (example: 10px, 10em)'),
          ),
          // paddingBottom
          array(
            'label' => $this->translate('Padding Bottom'),
            'id' => $this->id_PaddingBottom,
            'type' => 'textbox',
            'value' => '0px',
            'description' => $this->translate('Defines bottom padding for each section. Useful in case of using fixed footer. (example: 10px, 10em)'),
          ),
          // fixedElements
          array(
            'label' => $this->translate('Fixed Elements'),
            'id' => $this->id_FixedElements,
            'type' => 'textbox',
            'value' => '',
            'description' => $this->translate('Defines which elements will be taken off the scrolling structure of the plugin which is necessary when using the keep elements fixed with css. Enter comma seperated element selectors. (example: #element1, .element2)'),
          ),
          // normalScrollElements
          array(
            'label' => $this->translate('Normal Scroll Elements'),
            'id' => $this->id_NormalScrollElements,
            'type' => 'textbox',
            'value' => '',
            'description' => $this->translate('If you want to avoid the auto scroll when scrolling over some elements, this is the option you need to use. (useful for maps, scrolling divs etc.) Enter comma seperated element selectors. (example: #element1, .element2)'),
          ),
        ),
      );

      // Customizations accordion
      $customizations_accordion_fields = array(
        'title' => $this->translate('Customizations'),
        'type' => 'accordion',
        'dependency' => array( array('controller' => $this->id_fullPageEnable, 'condition' => '==', 'value' => true) ),
        'fields' => array(
          // enable VC Animations
          array(
            'label' => $this->translate('Enable WPBakery Page Builder Animations'),
            'id' => $this->id_cust_enableVCAnim,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter enables WPBakery Page Builder animations. (This may not work in some cases, and WPBakery Page Builder addon animations may not be supported.)'),
          ),
          // enable VC Animations
          array(
            'label' => $this->translate('Enable VC Animation Reset'),
            'id' => $this->id_cust_enableVCAnimReset,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_cust_enableVCAnim, 'condition' => '==', 'value' => true) ),
            'level' => '1',
            'description' => $this->translate('This parameter enables resetting WPBakery Page Builder animations on section and slide load. (This may not work in some cases, and WPBakery Page Builder addon animations may not be supported.)'),
          ),
          // Video fix
          array(
            'label' => $this->translate('Video Autoplay'),
            'id' => $this->id_cust_videoautoplay,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter plays the videos (HTML5 and Youtube) only when the section is in view and stops it otherwise.'),
          ),
          // Force remove theme margins
          array(
            'label' => $this->translate('Force Remove Theme Margins'),
            'id' => $this->id_cust_forceRemoveThemeMargins,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter forces to remove theme wrapper margins and paddings.'),
          ),
          // Force theme header fixed
          array(
            'label' => $this->translate('Force Fixed Theme Header'),
            'id' => $this->id_cust_forceFixedThemeHeader,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter forces to make theme header fixed on top.'),
          ),
          // Theme Header Selector
          array(
            'label' => $this->translate('Force Fixed Theme Header'),
            'id' => $this->id_cust_forceFixedThemeHeaderSelector,
            'type' => 'textbox',
            'value' => 'header',
            'level' => '1',
            'dependency' => array( array('controller' => $this->id_cust_forceFixedThemeHeader, 'condition' => '==', 'value' => true) ),
            'description' => $this->translate('This parameter is the theme header CSS selector. (Example: .header)'),
          ),
          // Page Builder Container Fix
          array(
            'label' => $this->translate('Page Builder Container Fix'),
            'id' => $this->id_cust_pbContainerFix,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter fixes the customized Page Builder Containers.'),
          ),
          // Page Builder Container Fix Selector
          array(
            'label' => $this->translate('Page Builder Container Selector'),
            'id' => $this->id_cust_pbContainerSelector,
            'type' => 'textbox',
            'value' => '',
            'level' => '1',
            'dependency' => array( array('controller' => $this->id_cust_pbContainerFix, 'condition' => '==', 'value' => true) ),
            'description' => $this->translate('This parameter is the customized Page Builder container selector. Leave empty for default selectors.'),
          ),
          // FullPage Extensions
          array(
            'label' => $this->translate('FullPage Extensions'),
            'id' => $this->id_cust_extensions,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter enables fullpage extensions if you have one. You will need to enqueue the javascript files yourself.'),
          ),
          // FullPage Extension URL
          array(
            'label' => $this->translate('FullPage Extension URL'),
            'id' => $this->id_cust_extensionUrl,
            'type' => 'textbox',
            'value' => '',
            'level' => '1',
            'dependency' => array( array('controller' => $this->id_cust_extensions, 'condition' => '==', 'value' => true) ),
            'description' => $this->translate('This parameter is the full URL of the extension file.'),
          ),
          // Extra Parameters
          array(
            'label' => $this->translate('Extra Parameters'),
            'id' => $this->id_ExtraParameters,
            'type' => 'textbox',
            'description' => $this->translate('If there are parameters you want to include, add these parameters (comma seperated)') .
                            '<br/>' .
                            $this->translate('Example: parameter1:true,parameter2:15'),
          ),
        ),
      );

      // Events accordion
      $events_accordion_fields = array(
        'title' => $this->translate('Events'),
        'type' => 'accordion',
        'dependency' => array( array('controller' => $this->id_fullPageEnable, 'condition' => '==', 'value' => true) ),
        'fields' => array(
          // afterRender enable
          array(
            'label' => $this->translate('afterRender'),
            'id' => $this->id_afterRenderEnable,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('Fired just after the structure of the page is generated.'),
          ),
          // afterRender
          array(
            'id' => $this->id_evt_afterRender,
            'type' => 'textarea',
            'value' => 'function(){&#13;&#10;  /* var pluginContainer = this; */&#13;&#10;  /* console.log("afterRender event fired."); */&#13;&#10;}',
            'dependency' => array( array('controller' => $this->id_afterRenderEnable, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
          // afterResize enable
          array(
            'label' => $this->translate('afterResize'),
            'id' => $this->id_afterResizeEnable,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('Fired after resizing the browsers window.'),
          ),
          // afterResize
          array(
            'id' => $this->id_evt_afterResize,
            'type' => 'textarea',
            'value' => 'function(width, height){&#13;&#10;  /* var fullpageContainer = this; */&#13;&#10;  /* console.log("afterResize event fired."); */&#13;&#10;}',
            'dependency' => array( array('controller' => $this->id_afterResizeEnable, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
          // afterLoad enable
          array(
            'label' => $this->translate('afterLoad'),
            'id' => $this->id_afterLoadEnable,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('Fired once the sections have been loaded, after the scrolling has ended.'),
          ),
          // afterLoad
          array(
            'id' => $this->id_evt_afterLoad,
            'type' => 'textarea',
            'value' => 'function(origin, destination, direction){&#13;&#10;  /* var loadedSection = this; */&#13;&#10;  /* console.log("afterLoad event fired."); */&#13;&#10;}',
            'dependency' => array( array('controller' => $this->id_afterLoadEnable, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
          // onLeave enable
          array(
            'label' => $this->translate('onLeave'),
            'id' => $this->id_onLeaveEnable,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('Fired once the user leaves a section.'),
          ),
          // onLeave
          array(
            'id' => $this->id_evt_onLeave,
            'type' => 'textarea',
            'value' => 'function(origin, destination, direction){&#13;&#10;  /* var leavingSection = this; */&#13;&#10;  /* console.log("onLeave event fired."); */&#13;&#10;}',
            'dependency' => array( array('controller' => $this->id_onLeaveEnable, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
          // afterSlideLoad enable
          array(
            'label' => $this->translate('afterSlideLoad'),
            'id' => $this->id_afterSlideLoadEnable,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('Fired once the slide of a section has been loaded, after the scrolling has ended.'),
          ),
          // afterSlideLoad
          array(
            'id' => $this->id_evt_afterSlideLoad,
            'type' => 'textarea',
            'value' => 'function(section, origin, destination, direction){&#13;&#10;  /* var loadedSlide = this; */&#13;&#10;  /* console.log("afterSlideLoad event fired."); */&#13;&#10;}',
            'dependency' => array( array('controller' => $this->id_afterSlideLoadEnable, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
          // onSlideLeave enable
          array(
            'label' => $this->translate('onSlideLeave'),
            'id' => $this->id_onSlideLeaveEnable,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('Fired once the user leaves a slide to go another.'),
          ),
          // onSlideLeave
          array(
            'id' => $this->id_evt_onSlideLeave,
            'type' => 'textarea',
            'value' => 'function(section, origin, destination, direction){&#13;&#10;  /* var leavingSlide = this; */&#13;&#10;  /* console.log("onSlideLeave event fired."); */&#13;&#10;}',
            'dependency' => array( array('controller' => $this->id_onSlideLeaveEnable, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
          // afterResponsive enable
          array(
            'label' => $this->translate('afterResponsive'),
            'id' => $this->id_afterresponsive,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('The javascript code that runs after normal mode is changed to responsive mode or responsive mode is changed to normal mode.'),
          ),
          // afterResponsive
          array(
            'id' => $this->id_evt_afterresponsive,
            'type' => 'textarea',
            'value' => 'function(isResponsive){&#13;&#10;  /* console.log("afterResponsive event fired."); */&#13;&#10;}',
            'dependency' => array( array('controller' => $this->id_afterresponsive, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
          // Before FullPage enable
          array(
            'label' => $this->translate('Before FullPage'),
            'id' => $this->id_beforefullpage,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('The javascript code that runs right after document is ready and before fullpage is called.'),
          ),
          // Before FullPage
          array(
            'id' => $this->id_evt_beforefullpage,
            'type' => 'textarea',
            'value' => '/* console.log("Before FullPage!"); */',
            'dependency' => array( array('controller' => $this->id_beforefullpage, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
          // After FullPage enable
          array(
            'label' => $this->translate('After FullPage'),
            'id' => $this->id_afterfullpage,
            'type' => 'checkbox',
            'value' => 'off',
            'description' => $this->translate('The javascript code that runs right after document is ready and after fullpage is called.'),
          ),
          // After FullPage
          array(
            'id' => $this->id_evt_afterfullpage,
            'type' => 'textarea',
            'value' => '/* console.log("After FullPage!"); */',
            'dependency' => array( array('controller' => $this->id_afterfullpage, 'condition' => '==', 'value' => true) ),
            'class' => 'mcw_raw',
            'raw' => true,
          ),
        ),
      );

      // Advanced accordion
      $advanced_accordion_fields = array(
        'title' => $this->translate('Advanced'),
        'type' => 'accordion',
        'dependency' => array( array('controller' => $this->id_fullPageEnable, 'condition' => '==', 'value' => true) ),
        'fields' => array(
          // enableTemplate
          array(
            'label' => $this->translate('Enable Empty Page Template'),
            'id' => $this->id_EnableTemplate,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter defines if page will be redirected to the defined template. The template is independent from the theme and is an empty page template if not defined.'),
          ),
          // templateRedirect
          array(
            'label' => $this->translate('Use Template Redirect'),
            'id' => $this->id_TemplateRedirect,
            'type' => 'checkbox',
            'dependency' => array( array('controller' => $this->id_EnableTemplate, 'condition' => '==', 'value' => true) ),
            'level' => '1',
            'description' => $this->translate('This parameter defines if template will be redirected or included. If set, template will be redirected, otherwise template will be included. Play with this setting to see the best scenario that fits.'),
          ),
          // Template Path
          array(
            'label' => $this->translate('Template Path'),
            'id' => $this->id_TemplatePath,
            'type' => 'textbox',
            'dependency' => array( array('controller' => $this->id_EnableTemplate, 'condition' => '==', 'value' => true) ),
            'level' => '1',
            'description' => $this->translate('If you want to use your own template, put the template path and template name here. If left empty, an empty predefined page template will be used.') .
                            '<br/>' .
                            $this->translate('Example') . ': ' . get_home_path() . 'my_template.php',
          ),
          // Remove theme JS
          array(
            'label' => $this->translate('Remove Theme JS'),
            'id' => $this->id_RemoveThemeJS,
            'type' => 'checkbox',
            'description' => $this->translate('This parameter removes theme javascript from output. Be aware, this might crash the page output if the theme has JS output on the head section.'),
          ),
          // Remove JS
          array(
            'label' => $this->translate('Remove JS'),
            'id' => $this->id_RemoveJS,
            'type' => 'textbox',
            'description' => $this->translate('This parameter removes specified javascript from output. Be aware, this might crash the page output. Write javascript names with comma in between.'),
          ),
          // Section Selector
          array(
            'label' => $this->translate('Section Selector'),
            'id' => $this->id_SectionSelector,
            'type' => 'textbox',
            'description' => $this->translate('This parameter changes section selector. Useful for themes that use customized WPBakery Page Builder. Example .wpb_row'),
          ),
          // Slide Selector
          array(
            'label' => $this->translate('Slide Selector'),
            'id' => $this->id_SlideSelector,
            'type' => 'textbox',
            'description' => $this->translate('This parameter changes slide selector. Useful for themes that use customized WPBakery Page Builder. Example: .wpb_column'),
          ),
        ),
      );

      // Meta box groups array
      $groups = array($full_page_enable_section, $nav_accordion_fields, $scrolling_accordion_fields,
        $design_accordion_fields, $events_accordion_fields, $customizations_accordion_fields,
        $advanced_accordion_fields);

      // Create meta box
      $this->meta_box = new MCW_MetaBox($this->meta_box_id, $this->translate('Full Page Settings'), $groups, $post_types);
    }

    // WPBakery Page Builder admin interface, add full page tab parameters and metabox
    public function on_admin_init() {
      // Check required WPBakery Page Builder version
      // Check if WPBakery Page Builder is activated
      if (defined('WPB_VC_VERSION')) {
        // Compare WPBakery Page Builder version with the required one
        if (version_compare($this->vc_RequiredVersion, WPB_VC_VERSION, '>' )) {
          add_action( 'admin_notices', array($this, 'wpbNotCompatible') );
        }
      }
      else {
        // WPBakery Page Builder not activated
        add_action( 'admin_notices', array($this, 'wpbNotActivated') );
      }

      // Initialize meta box
      $this->init_meta_box();

      if(function_exists('vc_add_params')) {
        vc_add_params( 'vc_row', array(
          array(
            'type' => 'dropdown',
            'class' => '',
            'heading' => $this->translate('Section Behaviour'),
            'param_name' => $this->vc_SectionBehaviour,
            'admin_label' => true,
            'value' => array(
              $this->translate('Full Height') => 'off',
              $this->translate('Auto Height') => 'on',
              $this->translate('Responsive Auto Height') => 'responsive',
              $this->translate('Top Fixed Header') => 'fixed_top',
              $this->translate('Bottom Fixed Footer') => 'fixed_bottom',
              ),
            'description' => $this->translate('Select section row behaviour.'),
            'group' => $this->vcGroupName,
          ),
          array(
            'type' => 'textfield',
            'class' => '',
            'heading' => $this->translate('Anchor'),
            'param_name' => $this->vc_Anchor,
            'value' => '',
            'description' => $this->translate('Enter an anchor (ID).'),
            'dependency' => array('element' => $this->vc_SectionBehaviour, 'value' => array('off', 'on', 'responsive')),
            'group' => $this->vcGroupName,
          ),
          array(
            'type' => 'textfield',
            'class' => '',
            'heading' => $this->translate('Tooltip'),
            'param_name' => $this->vc_Tooltip,
            'dependency' => array('element' => $this->vc_SectionBehaviour, 'value' => array('off', 'on', 'responsive')),
            'value' => '',
            'group' => $this->vcGroupName,
          ),
          array(
            'type' => 'checkbox',
            'class' => '',
            'heading' => $this->translate('Columns as Slides'),
            'param_name' => $this->vc_ColumnSlides,
            'dependency' => array('element' => $this->vc_SectionBehaviour, 'value' => array('off', 'on', 'responsive')),
            'value' => '',
            'group' => $this->vcGroupName,
            'description' => $this->translate('Enable if you want to show each column in this row as slides.'),
          ),
          array(
            'type' => 'checkbox',
            'class' => '',
            'heading' => $this->translate('No Scrollbars'),
            'param_name' => $this->vc_NoScrollbar,
            'dependency' => array('element' => $this->vc_SectionBehaviour, 'value' => array('off', 'on', 'responsive')),
            'value' => '',
            'group' => $this->vcGroupName,
            'description' => $this->translate('Enable if scrolloverflow is enabled but you don\'t want to show scrollbars for this section.'),
          ),
          array(
            'type' => 'colorpicker',
            'class' => '',
            'heading' => $this->translate('Section Main Color'),
            'param_name' => $this->vc_SectionMainColor,
            'dependency' => array('element' => $this->vc_SectionBehaviour, 'value' => array('off', 'on', 'responsive')),
            'value' => '',
            'group' => $this->vcGroupName,
            'param_holder_class' => 'mcw_fp_vc_colorpicker',
            'description' => $this->translate('Change main navigation color for this section. Leave empty to use default values.'),
          ),
          array(
            'type' => 'colorpicker',
            'class' => '',
            'heading' => $this->translate('Section Hover Color'),
            'param_name' => $this->vc_SectionHoverColor,
            'dependency' => array('element' => $this->vc_SectionBehaviour, 'value' => array('off', 'on', 'responsive')),
            'value' => '',
            'group' => $this->vcGroupName,
            'param_holder_class' => 'mcw_fp_vc_colorpicker',
            'description' => $this->translate('Change hover navigation color for this section. Leave empty to use default values.'),
          ),
          array(
            'type' => 'colorpicker',
            'class' => '',
            'heading' => $this->translate('Section Active Color'),
            'param_name' => $this->vc_SectionActiveColor,
            'dependency' => array('element' => $this->vc_SectionBehaviour, 'value' => array('off', 'on', 'responsive')),
            'value' => '',
            'group' => $this->vcGroupName,
            'param_holder_class' => 'mcw_fp_vc_colorpicker',
            'description' => $this->translate('Change active navigation color for this section. Leave empty to use default values.'),
          )
        ) );
      }
    }

    // WPBakery Page Builder not compatible message
    public function wpbNotCompatible() {
      $template = strtr(
        $this->translate('%1s plugin requires %2s.'),
        array(
          "%1s" => "<strong>" . $this->translate('FullPage for WPBakery Page Builder') . "</strong>",
          "%2s" => "<strong>" . $this->translate('WPBakery Page Builder ' . $this->vc_RequiredVersion . ' or greater') . "</strong>",
        )
      );

      echo '<div class="updated"><p>' . $template . '</p></div>';
    }

    // WPBakery Page Builder not activated message
    public function wpbNotActivated() {
      $template = strtr(
        $this->translate('%1s plugin requires %2s plugin installed and activated.'),
        array(
          "%1s" => "<strong>" . $this->translate('FullPage for WPBakery Page Builder') . "</strong>",
          "%2s" => "<strong>" . $this->translate('WPBakery Page Builder') . "</strong>",
        )
      );

      echo '<div class="updated"><p>' . $template . '</p></div>';
    }
  }
}

// Create MCW Full Page class
if(class_exists('MCW_FullPage')) {
  $MCW_FullPage = new MCW_FullPage;
}

// TODO: Option for footer
// TODO: column full height option
