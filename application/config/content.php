<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * config file for content variable settings
 */

$config['layout_folder'] = 'layouts/';


$config['minify_css'] = FALSE;
$config['css_folder'] = 'content/css/';
// css files to always be used
$config['css_files'] = array(
	'adapt/1200.min.css',
	'normalize.css',
	'styles.css'
	);

$config['minify_js'] = FALSE;
$config['js_folder'] = 'content/js/';
// js files to always be used
$config['js_files'] = array(
	'jquery-1.9.1.min.js',
	//'modernizr-2.6.2.js',
	'html5shiv.min.js'
	//'adapt-config.js',
	//'adapt.min.js'
	);

$config['images_folder'] = 'content/images/';



/**
 * meta tags
 * an array of arrays
 * each set of key values pairs will be the context="content" of a meta tag
 * where key = context, and value = content
 * this collection is always to be used
 * page specific meta tags can be declared in any class derived from MY_Controller
 *
 * examples:
 * array('content' => 'John Doe', 'name' => 'author')
 * will output
 * <meta content="John Doe" name="author" />
 *
 * 
 * array('http-equiv' => 'Content-Type', 'content' => 'text/html', 'charset' => 'utf-8')
 * will output
 * <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 */
$config['meta_tags'] = array(
		array('name' => 'keywords', 'content' => 'code, igniter, kindling'),
		array('name' => 'description', 'content' => 'This is a webpage')
	);


/**
 * link tags
 * same deal as with the meta tags
 * please note that favicon is done automatically with the 'favicon_link' below
 */
$config['link_tags'] = array(
	);


/**
 * favicon link
 * name of the favicon image to use on the page
 * can be a file located in the 'images_folder' or a full http address
 */
$config['favicon_link'] = 'favicon.ico';