<?php

/*
Plugin Name: Tus Torneos Gestor
Plugin URI: zalean.com
Description: Plugin para gestionar tarjetas de campos y resultados de jugadores
Version: 1.0.0
Author: zalean.com
Author URI: zalean.com
License: GPLv2
*/

/* 
Copyright (C) 2018 juanantonio

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


include_once dirname(__FILE__).'/ttgconstant.php';
include_once TTG_PLUGIN_INCLUDES.'ttghelper.php';
require_once TTG_PLUGIN_BASENAME.'ttgviewbase.php';
require_once TTG_PLUGIN_ENTITYS.'ttggestor.php';
require_once TTG_PLUGIN_CUSTOMS.'ttgcustomfields.php';
require_once TTG_PLUGIN_CUSTOMS.'ttgcustomrankings.php';
require_once TTG_PLUGIN_INCLUDES.'ajax/ttgajax.php';
require_once TTG_PLUGIN_INCLUDES.'admin/ttgtabsadmin.php';
require_once TTG_PLUGIN_SHORTCODES.'ttgshortcodes.php';

$ttggestor = new ttgGestor();
new ttgCustomFields($ttggestor);
new ttgCustomRankings($ttggestor);
new ttgAjax($ttggestor);
new ttgTabsAdmin($ttggestor);
new ttgShortcodes($ttggestor);

function tus_torneos_gestor_activate() {

}


function tus_torneos_gestor_deactivate() {

}

function carga_estilos_plugin()
{   
    if(get_admin_page_title()=='Tus Torneos Gestor'){
        wp_register_style( 'ttg_estilos', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',array(),time()); 
        wp_enqueue_style( 'ttg_estilos' );
        wp_register_style( 'ttg_select2_estilos', plugin_dir_url( __FILE__ ) .'assets/css/select2.min.css',array(),time()); 
        wp_enqueue_style( 'ttg_select2_estilos' );
        wp_register_style( 'ttg_custom_estilos', plugin_dir_url( __FILE__ ) .'assets/css/ttg_p_styles.css?v=123',array(),time()); 
        wp_enqueue_style( 'ttg_custom_estilos' );
        
    }
}
add_action('admin_menu', 'carga_estilos_plugin');

function carga_js_plugin (){
    if(get_admin_page_title()=='Tus Torneos Gestor'){
        wp_register_script('ttg_js', plugin_dir_url( __FILE__ ) .'assets/js/bootstrap.js', array('jquery'), time(), true);
        wp_enqueue_script('ttg_js');
        wp_register_script('ttg_select2_js', plugin_dir_url( __FILE__ ) .'assets/js/select2.full.min.js', array('jquery'), time(), true);
        wp_enqueue_script('ttg_select2_js');
        wp_register_script('ttg_select2_es_js', plugin_dir_url( __FILE__ ) .'assets/js/i18n/es.js', array('jquery'), time(), true);
        wp_enqueue_script('ttg_select2_es_js');
        wp_register_script('ttg_custom_js', plugin_dir_url( __FILE__ ) .'assets/js/ttg.js?v=123', array('jquery'), time(), true);
        wp_enqueue_script('ttg_custom_js');
        wp_register_script('ttg_result_js', plugin_dir_url( __FILE__ ) .'assets/js/ttgresults.js?v=123', array('jquery'), time(), true);
        wp_enqueue_script('ttg_result_js');
    }
    wp_enqueue_script('ttg-datepicker-js',plugin_dir_url( __FILE__ ) .'assets/js/ttgdatepicker.js',array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'),time(),true);	
    wp_enqueue_script('ttg-datepicker-js');
}
add_action("admin_menu", "carga_js_plugin");

function carga_js_product (){
    wp_enqueue_script('ttg-product-filters-js',plugin_dir_url( __FILE__ ).'assets/js/ttgproductfilters.js',array('jquery'),time(),true);	
    wp_enqueue_script('ttg-product-filters-js');
}
add_action("wp_print_styles", "carga_js_product");