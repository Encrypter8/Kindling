<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * config file for content variable settings
 */

$config['layout_folder'] = 'layouts/';
$config['layout'] = 'default';


$config['css_folder'] = 'content/css/';
$config['css_files'] = array(
		'adapt/1200.min.css',
		'normalize.css',
		'styles.css'
	);

$config['js_folder'] = 'content/js/';
$config['js_files'] = array(
		'jquery-1.9.1.min.js',
		//'modernizr-2.6.2.js',
		'html5shiv.min.js'
		//'adapt-config.js',
		//'adapt.min.js'
	);

$config['images_folder'] = 'content/images/';


// key is optional if you would like to option for a local override
$config['html_classes'] = array(
		'override' => 'me'
	);
$config['html_id'] = '';
$config['html_attrs'] = array(
		'xml:lang' => 'en',
		'xmlns' => 'http://www.w3.org/1999/xhtml'
	);


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
		array('content' => 'text/html; charset=UTF-8', 'http-equiv' => 'Content-Type'),
		array('name' => 'keywords', 'content' => 'code, igniter, layout'),
		'description' => array('name' => 'description', 'content' => 'This website was made using the Layout Library extention for Codeigniter!')
	);

/**
 * link tags
 * same deal as with the meta tags
 * key's in the top level array are optional, and can but used if you want to set an overridable initial value
 */
$config['link_tags'] = array(
		'favicon' => array('rel' => 'shortcut icon', 'href' => 'content/images/favicon.ico')
	);
