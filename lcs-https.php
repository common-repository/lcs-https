<?php
/*
Plugin Name: LCS HTTPS
Plugin URI: http://www.latcomsystems.com/index.cfm?SheetIndex=wp_lcs_https
Description: This plugin redirects specific pages to HTTPS. All other pages will remain HTTP.
Version: 1.0
Author: LatCom Systems
Author URI: http://www.latcomsystems.com/
License: GPLv2
Licence URI: http://www.gnu.org/licenses/gpl-2.0.html
Copyright 2016 LatCom Systems
*/

function lcs_https_is_https()
{
	if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on") :
		return true;
	elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == "https") :
		return true;
	elseif (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) == "on") :
		return true;
	else :
		return false;
	endif;
}

function lcs_https_aritem_in_str($arr, $string) 
{
    foreach ($arr as $search) :
        if (stripos($string, $search) !== false) return true;
    endforeach;
    return false;
}

function lcs_https_redirect() 
{
	$lcs_https_flag = 0;
	if ( (!is_admin()) && (!preg_match('/wp-login/', $_SERVER['REQUEST_URI']) === true) ) :
		$lcs_https_url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$lcs_https_slug = $_SERVER['REQUEST_URI'];
		$lcs_https_options = get_option('lcs_https_options');
		$lcs_ar_options = explode(',', $lcs_https_options['https_pages']);
		if (lcs_https_is_https()):
			if (lcs_https_aritem_in_str($lcs_ar_options, $lcs_https_slug) === FALSE) :
				$lcs_https_protocol = "http://";
				$lcs_https_flag = 1;
			else :
				$lcs_https_flag = 0;
			endif;
		else :
			if (lcs_https_aritem_in_str($lcs_ar_options, $lcs_https_slug) === FALSE) :
				$lcs_https_flag = 0;
			else :
				$lcs_https_protocol = "https://";
				$lcs_https_flag = 1;
			endif;
		endif;
		if ($lcs_https_flag == 1) :
			header("Location: $lcs_https_protocol$lcs_https_url");
			exit;
		endif;
	endif;
}

function lcs_https_options_init()
{
	register_setting( 'lcs_https_options_group', 'lcs_https_options', 'lcs_https_options_validate' );
}

function lcs_https_options_add_page() 
{
	add_options_page('LCS HTTPS Options Page', 'LCS HTTPS', 'manage_options', 'lcs_https_options', 'lcs_https_options_page');
}

function lcs_https_options_page() 
{
	?>
	<div class="wrap">
		<h2>LCS HTTPS Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields('lcs_https_options_group'); ?>
			<?php $lcs_https_options = get_option('lcs_https_options'); ?>
			<table class="form-table">
				<!-- Text Area Control -->
				<tr>
					<th scope="row">Comma separated list of pages that require HTTPS (SSL):</th>
					<td>
						<textarea name="lcs_https_options[https_pages]" rows="5" cols="100" type='textarea'><?php echo $lcs_https_options['https_pages']; ?></textarea>
						<br /><span style="color:#666666;margin-left:2px;">Enter comma-separated page slugs here.  Example: for www.mysite.com/<strong><i>secure-page</i></strong>/ you would enter <strong><i>secure-page</i></strong>.</span>
					</td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
			</p>
		</form>
	</div>
	<?php	
}

function lcs_https_options_validate($input) 
{
	$input['https_pages'] = strip_tags($input['https_pages']);
	$input['https_pages'] = str_replace(" ", "", $input['https_pages']);
	return $input;
}

function lcs_https_force()
{
    if (lcs_https_is_https()) :
	    ob_start();
	endif;
}

function lcs_https_output_page()
{
    if (lcs_https_is_https()) :
		$site_url = substr(site_url(), strpos(site_url(),'://') + 3);
	    echo str_ireplace( 'http://'.$site_url, 'https://'.$site_url, ob_get_clean() );
	endif;
}

add_action( 'template_redirect', 'lcs_https_force', 1 );
add_action( 'wp_footer', 'lcs_https_output_page', 99 );
add_action( 'init', 'lcs_https_redirect', 0 );
add_action('admin_init', 'lcs_https_options_init' );
add_action('admin_menu', 'lcs_https_options_add_page');

?>
