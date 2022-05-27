<?php function childtheme_iefix() { ?>
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('stylesheet_directory') ?>/ie.css" />
<![endif]-->
<?php }
add_action('wp_head', 'childtheme_iefix');
?>
<?php 
// This options page mainly follows the WordPress Settings API Tutorial at
// http://ottodestruct.com/blog/2009/wordpress-settings-api-tutorial/

add_action('admin_menu', 'theme_admin_add_page');
function theme_admin_add_page() {
	add_theme_page(
		'Cool Orange Theme Options',
		'Cool Orange Theme Options',
		'manage_options',
		'coolorange',
		'theme_options_page'
	);
}

function theme_options_page() {
	?>
	<div class="wrap" style="margin-bottom: 20px;">
	<div id="icon-themes" class="icon32"><br /></div><h2>Cool Orange Theme Options</h2>
	<?php if($_REQUEST['settings-updated'] == 'true') {
		echo '<div id="message" class="updated fade"><p>Cool Orange options saved.</p></div>';
	} ?>
	<form action="options.php" method="post" name="options_form">
	<?php settings_fields('coolorange_theme_options'); ?>
	<?php do_settings_sections('coolorange'); ?>
	<div style="text-align: center; padding: 20px;"><input name="Submit" class="button-primary" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" /></div>
	</form>
	</div>
	<?php 
}

add_action('admin_init', 'theme_admin_init');
function theme_admin_init() {
	register_setting(
		'coolorange_theme_options', 
		'coolorange_theme_options',
		'coolorange_options_validate'
	);

	// what each parameter represents: 
	// add_settings_field($id, $title, $callback, $page, $section, $args);
	add_settings_section(
		'coolorange_logo_main', 
		'Logo Section Settings', 
		'logo_section_text', 
		'coolorange'
	);
	add_settings_field(
		'upload_image_button', 
		'<strong>Upload logo to the Media Library</strong>', 
		'file_upload_button', 
		'coolorange', 
		'coolorange_logo_main'
	); // Upload Logo button
	add_settings_field(
		'image_url', 
		'<strong>Logo location</strong>', 
		'file_location', 
		'coolorange', 
		'coolorange_logo_main'
	); // logo url field
	add_settings_field(
		'logo_width',
		'<strong>Logo width</strong>',
		'logo_width',
		'coolorange',
		'coolorange_logo_main'
	); // logo width field
	add_settings_field(
		'logo_height',
		'<strong>Logo height</strong>',
		'logo_height',
		'coolorange',
		'coolorange_logo_main'
	); // logo height field
	add_settings_field(
		'padding_top',
		'<strong>Padding top</strong>',
		'padding_top',
		'coolorange',
		'coolorange_logo_main'
	); // logo padding top
	add_settings_field(
		'padding_right',
		'<strong>Padding right</strong>',
		'padding_right',
		'coolorange',
		'coolorange_logo_main'
	); // logo padding right
	add_settings_field(
		'padding_bottom',
		'<strong>Padding bottom</strong>',
		'padding_bottom',
		'coolorange',
		'coolorange_logo_main'
	); // logo padding bottom
	add_settings_field(
		'padding_left',
		'<strong>Padding left</strong>',
		'padding_left',
		'coolorange',
		'coolorange_logo_main'
	);
	add_settings_field(
		'remove_blogtitle_checkbox',
		'<strong>Remove blog title</strong>',
		'remove_blogtitle',
		'coolorange',
		'coolorange_logo_main'
	);
	add_settings_field(
		'reset_button',
		'<strong>Reset to original heading</strong>',
		'reset_button',
		'coolorange',
		'coolorange_logo_main'
	);
}

function logo_section_text() { ?>
	<p>In this section, you can replace the standard blog title heading with a custom logo. The logo cannot be wider than <strong>960 pixels</strong>.</p>
	<p><strong>How to upload a logo to replace the heading:</strong></p>
		<div style="background-color: #FFFFFF; border: 1px solid #BBBBBB; padding: 30px; margin-bottom: 10px;">
		<ul style="list-style: disc;">
			<li>Upload the image from your computer to the Media Library using the <strong>Upload Logo</strong> button below. Close the popup box by clicking the X in the upper right corner</li>
			<li>Go to the <strong>Media</strong> button at the left to access the Media Library. Look for the file you just uploaded. It should be the file at the top of the list</li>
			<li>Once you mouseover the image, click <strong>Edit</strong></li>
			<li>In the Edit Media dialog, highlight (Ctrl a) the url in the <strong>File URL</strong> textbox</li>
			<li>Note the width and height of the image</li>
			<li><strong>Copy</strong> (ctrl c) the url and return to this page by clicking <strong>Appearance</strong>, then <strong>Cool Orange Options</strong></li>
			<li><strong>Paste</strong> (ctrl v) the url into the <strong>Logo location</strong> box below</li>
			<li><strong>Paste</strong> (ctrl v) the width and height of the image into the <strong>Logo width</strong> and <strong>Logo height</strong> boxes below</li>
		</ul>
	</div>
<?php }

function file_upload_button() {
	$options = get_option('coolorange_theme_options');
	echo '<input id="upload_image_button" class="button-secondary" type="button" name="coolorange_theme_options[upload_image_button]" value="Upload Logo" />';
}
//Scripts to load WP's Media Library panel
//http://www.webmaster-source.com/2010/01/08/using-the-wordpress-uploader-in-your-plugin-or-theme/
// Associated with file_upload_button function
function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', trailingslashit( get_stylesheet_directory_uri()).'scripts/invoke_uploader.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}

function my_admin_styles() {
	wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'coolorange') {
	add_action('admin_print_scripts', 'my_admin_scripts');
	add_action('admin_print_styles', 'my_admin_styles');
} ?>
<?php 
function file_location() { //opens file_location function
	$options = get_option('coolorange_theme_options');
	echo "<input id='image_url' type='text' value='" . esc_url($options['image_url']) . "' size='60' name='coolorange_theme_options[image_url]' /><br /><strong>File type must have the file extension .jpg, .jpeg, .gif or .png</strong>.";
} // closes file_location function
// {$options['image_url']}
function logo_width() {
	$options = get_option('coolorange_theme_options');
	echo "<input id='image_width' type='text' value='{$options['image_width']}' size='6' name='coolorange_theme_options[image_width]' /> Enter logo width in pixels (for example <strong>800px</strong>).";
}

function logo_height() { 
	$options = get_option('coolorange_theme_options');
	echo "<input id='image_height' type='text' value='{$options['image_height']}' size='6' name='coolorange_theme_options[image_height]' /> Enter logo height in pixels (for example <strong>90px</strong>).";
}

function padding_top() { 
	$options = get_option('coolorange_theme_options');
	echo "<input id='padding_top' type='text' value='{$options['padding_top']}' size='6' name='coolorange_theme_options[padding_top]' /><br /> Enter top padding in pixels, ems or percentages. To use the defaults, leave the text field as is.";
}

function padding_right() { 
	$options = get_option('coolorange_theme_options'); 
	echo "<input id='padding_right' type='text' value='{$options['padding_right']}' size='6' name='coolorange_theme_options[padding_right]' /><br /> Enter right side padding in pixels, ems or percentages. To use the defaults, leave the text field as is.";
}

function padding_bottom() { 
	$options = get_option('coolorange_theme_options');
	echo "<input id='padding_bottom' type='text' value='{$options['padding_bottom']}' size='6' name='coolorange_theme_options[padding_bottom]' /><br /> Enter bottom padding in pixels, ems or percentages. To use the defaults, leave the text field as is.";
}

function padding_left() { 
	$options = get_option('coolorange_theme_options');
	echo "<input id='padding_left' type='text' value='{$options['padding_left']}' size='6' name='coolorange_theme_options[padding_left]' /><br /> Enter left padding in pixels, ems or percentages. To use the defaults, leave the text field as is.";
}

function remove_blogtitle() { 
	$options = get_option('coolorange_theme_options');
	echo "<input type='checkbox' id='remove_blogtitle' value='false' name='coolorange_theme_options[remove_blogtitle]'" . checked( (bool) $coolorange_theme_options['remove_blogtitle'], 1 ) . "' /><br /> Checking this box will remove the blog title and subtitle from the header. <strong>This will need to be checked when using a logo background</strong>.";
//{$options['remove_blogtitle']}
}

function reset_button() {
	$options = get_option('coolorange_theme_options');
	echo '<input id="reset_button" class="button-secondary" value="Reset all fields" name="coolorange_theme_options[reset_button]" /><br /> You must click <strong>Save Changes</strong> for the resetting to the default heading to take effect.';
}

function reset_script() {
	wp_register_script('reset-values', trailingslashit( get_stylesheet_directory_uri()).'scripts/resetLogoValues.js' );
	wp_enqueue_script('reset-values');
}

if (isset($_GET['page']) && $_GET['page'] == 'coolorange') {
	add_action('admin_print_scripts', 'reset_script');
}

function logo_css() {
	global $coolorange_theme_options;
	$coolorange_settings = get_option('coolorange_theme_options');
	
	$backgroundurl = $coolorange_settings['image_url'];
	$imagewidth = $coolorange_settings['image_width'];
	$imageheight = $coolorange_settings['image_height']; 
	$paddingtop = $coolorange_settings['padding_top'];
	$paddingright = $coolorange_settings['padding_right']; 
	$paddingbottom = $coolorange_settings['padding_bottom']; 
	$paddingleft = $coolorange_settings['padding_left']; 
	$removetitle = $coolorange_settings['remove_blogtitle']; ?>
	<style type="text/css">
		<!--
		#logo {
			<?php if ($backgroundurl) echo "background: url(" . $coolorange_settings['image_url'] . ") top center no-repeat";
				else echo "background: transparent"; ?>;
			width: <?php if ($imagewidth) echo $imagewidth; else echo "auto"; ?>;
			height: <?php if ($imageheight) echo $imageheight; else echo "auto"; ?>;
			padding-top: <?php if ($paddingtop) echo $paddingtop; else echo "1em"; ?>;
			padding-right: <?php if ($paddingright) echo $paddingright; else echo "2em"; ?>;
			padding-bottom: <?php if ($paddingbottom) echo $paddingbottom; else echo "1em"; ?>;
			padding-left: <?php if ($paddingleft) echo $paddingleft; else echo "2em"; ?>;
			margin: 0 auto;
		}

		#blog-title a {
			display: block;
			width: <?php if ($imagewidth) echo $imagewidth; else echo "auto"; ?>;
			height: <?php if ($imageheight) echo $imageheight; else echo "auto"; ?>;
			text-indent: <?php if ( $removetitle ) echo "-2000px"; else echo "0"; ?>;
		}

		#blog-description {
			text-indent: <?php if ( $removetitle ) echo "-2000px"; else echo "0"; ?>;
		}
		-->
		</style>
<?php } //closes logo_css function

add_action('wp_head', 'logo_css');

//Validation
function coolorange_options_validate($input) { // opens coolorange_options_validate function
$options = get_option('coolorange_theme_options');

//check filetypes for image url
$options['image_url'] = trim($input['image_url']);
//var_dump($options); // for debugging
if ( !preg_match ( '/\.(gif|jpg|jpeg|png)$/', $options['image_url'] ) ) { //opens if statement
	$options['image_url'] = ''; 
	//echo '<div id="message" style="color: red;"><p>File type must have the file extension .jpg, .jpeg, .gif or .png</p></div>';
	} // closes if statement
	
//check input on width to make sure it includes only numbers, letters and the precentage sign
$options['image_width'] = trim($input['image_width']);
if ( !preg_match ( '/[0-9](px|em|%)/', $options['image_width'] ) ) { //opens if statement
	$options['image_width'] = '';
	//echo '<div id="message" style="color: red;"><p>Width must be specified in px, em or %</p></div>';
	} // closes if statement
	
//check input on height to make sure it includes only numbers, letters and the precentage sign
$options['image_height'] = trim($input['image_height']);
if ( !preg_match ( '/[0-9](px|em|%)/', $options['image_height'] ) ) {
	$options['image_height'] = '';
	//echo '<div id="message" style="color: red;"><p>Height must be specified in px, em or %</p></div>';
	}
	
//check input on padding top to make sure it includes only numbers, letters and the percentage sign
$options['padding_top'] = trim($input['padding_top']);
if ( !preg_match ( '/[0-9](px|em|%)/', $options['padding_top'] ) ) {
	$options['padding_top'] = '';
	//echo '<div id="message" style="color: red;"><p>Padding top must be specified in px, em or %</p></div>';
	}
	
//check input on padding right to make sure it includes only numbers, letters and the percentage sign
$options['padding_right'] = trim($input['padding_right']);
if ( !preg_match ( '/[0-9](px|em|%)/', $options['padding_right'] ) ) {
	$options['padding_right'] = '';
	//echo '<div id="message" style="color: red;"><p>Padding right must be specified in px, em or %</p></div>';
	}
	
//check input on padding bottom to make sure it includes only numbers, letters and the percentage sign
$options['padding_bottom'] = trim($input['padding_bottom']);
if ( !preg_match ( '/[0-9](px|em|%)/', $options['padding_bottom'] ) ) {
	$options['padding_bottom'] = '';
	//echo '<div id="message" style="color: red;"><p>Padding bottom must be specified in px, em or %</p></div>';
	}

//check input on padding left to make sure it includes only numbers, letters and the percentage sign
$options['padding_left'] = trim($input['padding_left']);
if ( !preg_match ( '/[0-9](px|em|%)/', $options['padding_left'] ) ) {
	$options['padding_left'] = '';
	//echo '<div id="message" style="color: red;"><p>Padding top must be specified in px, em or %</p></div>';
	}
	
//check if checkbox has been checked
$options['remove_blogtitle'] = $input['remove_blogtitle'];
if ( !isset( $input['remove_blogtitle'] ) ) {
	$input['remove_blogtitle'] = null;
}
	return $options;
} // closes coolorange_options_validate function

if (isset($_GET['page']) && isset($_GET['page']) == 'coolorange')
	add_action('admin_notices', 'coolorange_options_validate'); //shows validation errors at the top of the page
?>