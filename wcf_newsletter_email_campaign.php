<?php
/*
Plugin Name: WCF Newsletter & Email Campaign
Plugin URI: http://wecodefuture.com
Description: WCF Newsletter & Email Campaign plugin provides you attractive newsletter interface & email capmapaign system.  
Version: 1.0
Author: WeCodeFuture
Author URI: http://wecodefuture.com
*/
	function wcf_newsletter_campaign_css() {
			wp_enqueue_style( 'wcf_bootstrap_min', plugin_dir_url( '_FILE_' ) . 'wcf-newsletter-email-campaign/asset/css/bootstrap.min.css', false, '5.2.2' );
		
			wp_enqueue_style( 'wcf_dbtable_min', plugin_dir_url( '_FILE_' ) . 'wcf-newsletter-email-campaign/asset/css/dbtable.css', false, '1.12.1' );
		}
		add_action( 'admin_enqueue_scripts', 'wcf_newsletter_campaign_css' );
		
		function wcf_newsletter_campaign_js() {
			
			wp_add_inline_script( 'jquery-core', 'window.$ = jQuery;' );
			wp_enqueue_script( 'wcf_bjquery_min_js', plugin_dir_url( '_FILE_' ) . 'wcf-newsletter-email-campaign/asset/js/bootstrap.min.js', true, '5.2.2' );
			wp_enqueue_script( 'wcf_popper_min_js', plugin_dir_url( '_FILE_' ) . 'wcf-newsletter-email-campaign/asset/js/1.12.9distumdpopper.min.js', true, '1.12' );
		//	wp_enqueue_script( 'wcf_ck_editor_js', plugin_dir_url( '_FILE_' ) . 'wcf-newsletter-email-campaign/asset/js/ckeditor.js', false, '4.19.1');
			wp_enqueue_script( 'wcf_dbtable_js', plugin_dir_url( '_FILE_' ) . 'wcf-newsletter-email-campaign/asset/js/jquery.dataTables.js', true, '1.12.1' );
			
		}
		add_action( 'admin_enqueue_scripts', 'wcf_newsletter_campaign_js' );
		
		


		register_activation_hook(__FILE__, 'wcf_newsletter_email_activate');
		register_deactivation_hook(__FILE__, 'wcf_newsletter_email_deactivate');

			function wcf_newsletter_email_activate(){
			
			 global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			$table_camp = $wpdb->prefix . 'wcf_camp_list';
			
			$sql1 = "CREATE TABLE IF NOT EXISTS `$table_camp`(
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
							`subject` varchar(220)  NOT NULL,
							`message` varchar(500)  NOT NULL,
							`recipient_type` varchar(500)  NOT NULL,

							PRIMARY KEY(id)
							)
							ENGINE=MyISAM DEFAULT CHARSET=utf8";

			$wpdb->query($sql1);
			}
			
			
			function wcf_newsletter_email_deactivate(){
			
				/* global $wpdb;
				$charset_collate = $wpdb->get_charset_collate();
				$table_camp = $wpdb->prefix . 'wcf_camp_list';
				
				  $sql = "DROP TABLE IF EXISTS $table_camp";

				$wpdb->query($sql);
				*/
				
			}
			
// Plugin setting page

	add_action('admin_menu', 'wcf_newsletter_campaign_menu');

	function wcf_newsletter_campaign_menu()
	{
		add_menu_page('WCF Newsletter & Campaign', 'WCF Newsletter & Campaign', 'administrator', dirname(__FILE__) , 'welcome_wcf_newsletter_screen');
		add_submenu_page(dirname(__FILE__) , 'Campaigns', 'Campaigns', 'manage_options', '/wcf-campaigns-list', 'wcf_compaigns');
		add_submenu_page(dirname(__FILE__) , 'Subscriber List', 'Subscriber List', 'manage_options', '/wcf-newsletter-subscriber', 'wcf_subscriber_list');

	}
	function welcome_wcf_newsletter_screen()
	{

	include ('welcome_wcf_newsletter_campaign.php');
	
	}
	function wcf_compaigns(){
		
		include ('campaign_list.php');
	}

	function wcf_subscriber_list(){
		
		include ('subscribers_list.php');
	}
	
	
		function wpb_admin_notice_warn() { 
		
?>
	
			<div class="notice notice-warning is-dismissible">
				
				<h4>Enjoying WCF Newsletter & Email Campaign ? </h4>
				<p>
		<?php
			echo wp_kses_post( sprintf(
				/** translators: %s: documentation URL **/
				__( 'Take a moment and give us a 5 star rating on wordpress. <a href="%s" target="_blank">Click here to review.</a>' ),
				'#'
			) );
		?>
				</p>
			</div>	  
	<?php	}
		add_action( 'admin_notices', 'wpb_admin_notice_warn' );
		
		
		
		function wcf_newsletter_frm(){
			
			
	?>
	<div class="container">
		<form method="post" action="" class="form-inline">
		<div class="mb-6 row">
			 
				<label for="name" class="col-sm-1 col-form-label">Name</label>
				<div class="col-sm-3">
				<input type="text" class="form-control" id="name" placeholder="Name" name="user_name" required>
				</div>
			
			   
				<label for="staticEmail2" class="col-sm-1 col-form-label">Email</label>
				<div class="col-sm-3">
				<input type="email" class="form-control"  id="staticEmail2" placeholder="email@example.com" name="email" required>
				</div>
			
			 
					<button type="submit" class="btn btn-primary col-sm-1 col-form-label"  name="subscribe" value="subscribe">Subscribe</button>
				
		</div>
	
		</form>
	</div>
		
	
	<?php
			if(isset($_POST['subscribe'])){
				
				$user_name = sanitize_text_field($_POST['user_name']);
				$user_email = sanitize_email($_POST['email']);
				$display_name = sanitize_text_field($_POST['user_name']);
			
			$new_subscriber = wp_insert_user( array(
			  'user_login' => $user_name,
			  'user_email' => $user_email,
			  'display_name' => $display_name,
			  'role' => 'subscriber'
			));
				if($new_subscriber){
				echo 'Subscribe Successfully';
				}
			}
		}
add_shortcode('wcf_newsletter_default', 'wcf_newsletter_frm');

	?>
	
<style>

.dataTables_wrapper .dataTables_length select{
	
	width:45px!important;
}
</style>