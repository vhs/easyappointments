<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Add custom values by settings them to the $config array.
// Example: $config['smtp_host'] = 'smtp.gmail.com'; 
// @link https://codeigniter.com/user_guide/libraries/email.html

$config['useragent'] = 'Easy!Appointments';
$config['protocol'] = 'mail'; // or 'smtp'
$config['mailtype'] = 'html'; // or 'text'
if( file_exists('/run/secrets/SMTP_HOST') )
	$config['smtp_host'] = trim(file_get_contents('/run/secrets/SMTP_HOST'));
if( file_exists('/run/secrets/SMTP_USER') )
	$config['smtp_user'] = trim(file_get_contents('/run/secrets/SMTP_USER'));
if( file_exists('/run/secrets/SMTP_PASS') )
	$config['smtp_pass'] = trim(file_get_contents('/run/secrets/SMTP_PASS'));
if( file_exists('/run/secrets/SMTP_CRYPTO') )
	$config['smtp_crypto'] = trim(file_get_contents('/run/secrets/SMTP_CRYPTO'));
if( file_exists('/run/secrets/SMTP_PORT') )
	$config['smtp_port'] = trim(file_get_contents('/run/secrets/SMTP_PORT'));

if(isset($config['smtp_host']))
	$config['protocol'] = 'smtp';
