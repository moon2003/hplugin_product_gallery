<?php
/*
Plugin Name: H-Product Gallery plugin.
Plugin URI: http://www.h-plugin.com
Description: 워드프레스용 상품 진열 플러그인입니다. 결제기능은 제외하고 쇼핑몰의 상품진열구성을 제공합니다.
Version: 1.0.0
Author: Chang moon
Author URI: http://www.thehto.com
License: GPL2
Text Domain: hpluginproductgallery
*/
 
/* Copyright HTO PLUGIN FOR KOREA (email : moon200@thehto.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/


// define pension variable

define('HPLUGIN_PRODUCT_GALLERY_VERSION','1.0.0');
define('HPLUGIN_PRODUCT_GALLERY_MINIMUM_WP_VERSION','3.8.0');
define('HPLUGIN_PRODUCT_GALLERY__PLUGIN_URL',plugin_dir_url(__FILE__) );
define('HPLUGIN_PRODUCT_GALLERY__PLUGIN_DIR',plugin_dir_path(__FILE__) );
define('HPLUGIN_PRODUCT_GALLERY__CONTENT_URL', WP_CONTENT_URL.'/uploads/hplugins_product_gallery/'  );
define('HPLUGIN_PRODUCT_GALLERY__CONTENT_DIR', WP_CONTENT_DIR.'/uploads/hplugins_product_gallery/'  );

require_once(HPLUGIN_PRODUCT_GALLERY__PLUGIN_DIR.'class.hpluginproductgallery.php');

register_activation_hook(__FILE__, array('Hpluginproductgallery','plugin_activate' ) );
register_deactivation_hook(__FILE__,array('Hpluginproductgallery','plugin_deactivate')  );

?>