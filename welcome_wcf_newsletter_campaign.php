  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

  <body>
	<div style="margin-top:30px; margin-bottom:50px;" >
	  <h4>Welcome to WCF Newsletter & Campaign System.</h4><br>
	  <p>You can use the shortcode <span style="color:red;">[wcf_newsletter_default]</span> to display newsletter form any where you want and get details of subscriber name & email.</p>

	<h3>WCF Campaign Form</h3>

	</div>

			<div id="campaign_form">
			
				<div style="max-width:75%;">	
				  <form method="post">
					<div class="form-group">
					  <label for="user_list">Select List:</label>
					  <select class="form-controls" id="user_list" name="seluser" required>
					  <option value="" selected disabled >Select User Role</option>
						<option class="wcf_user" value="All user">All User</option>
						<option class="wcf_customer" value="customer">Customer</option>
						<option class="wcf_subscriber" value="subscriber">Subscriber</option>
						<option class="wcf_author" value="author">Author</option>
					  </select>
					</div><br>
					<div class="form-group">
					  <label for="usr">Subject:</label>
					  &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="form-controls" id="subjec" name="subject" required>
					</div><br>
							
					
					<div class="form-group">
					  <label for="mail_message">Message:</label><br><br>
					
											    
					<?php wp_editor("","mail_message"); ?>
					
					</div>

					<br>
					
							
						 <br>
					<button type="submit" class="btn btn-primary" name="subcamp">Quick Campaign</button>
					</form>
					</div>
				</div>
			
			<div>
			<?php
			if(isset($_POST["subcamp"])){
				$subject = sanitize_text_field($_POST["subject"]);
				$message = sanitize_textarea_field($_POST["mail_message"]);
				$from = get_option('admin_email');
				$site_name = get_bloginfo( 'name' );
				$roletype = sanitize_text_field($_POST["seluser"]);
				
				

			if($roletype=='All user'){
					
					$args = array(
				'role'    =>  '',
				'orderby' => 'user_nicename',
				'order'   => 'ASC'
			);
			$users = get_users( $args );
				
			foreach ( $users as $user ) {
				$user_data= $user->user_email;
				//echo '<li>' . esc_html( $user->display_name ) .'&nbsp;'. '[' . esc_html( $user->user_email ) . ']</li>';
				$headers = array(
            'From: '.$site_name.' <' . $from . '>',
            'Content-Type: text/html; charset=UTF-8'
        );
        $headers = implode("\r\n", $headers);
        //Here put your Validation and send mail
        $sent = wp_mail($user_data, $subject, $message, $headers);
					
			}
			global $wpdb;
				$charset_collate = $wpdb->get_charset_collate();
				$table_camp = $wpdb->prefix . 'wcf_camp_list';
				$camp_list = "INSERT INTO $table_camp(`subject`, `message`, `recipient_type` ) VALUES ('$subject', '$message', '$roletype')";
				$run_sql = $wpdb->get_results($camp_list);
				echo"Successfully Sent";
			
			}else{
		
				$args = array(
				'role'    =>  $roletype,
				'orderby' => 'user_nicename',
				'order'   => 'ASC'
			);
				$users = get_users( $args );
					
						//$mail_list=$users['user_email'];
						//print_r($mail_list);
						
						foreach ( $users as $user ) {
							$user_data= $user->user_email;
							//echo '<li>' . esc_html( $user->display_name ) .'&nbsp;'. '[' . esc_html( $user->user_email ) . ']</li>';
								$headers = array(
						'From: '.$site_name.' <' . $from . '>',
						'Content-Type: text/html; charset=UTF-8'
					);
					$headers = implode("\r\n", $headers);
					//Here put your Validation and send mail
					$sent = wp_mail($user_data, $subject, $message, $headers);
						}
						
				global $wpdb;
				$charset_collate = $wpdb->get_charset_collate();
				$table_camp = $wpdb->prefix . 'wcf_camp_list';
				$camp_list = "INSERT INTO $table_camp(`subject`, `message`, `recipient_type` ) VALUES ('$subject', '$message', '$roletype')";
				$run_sql = $wpdb->get_results($camp_list);
				echo'<div id="success_msg">'."Successfully Sent".'</div>';
				}
				
			}
			?>
			
			</div>
			
	<style>
	  #user_list{
		  width:100%;
	  }
	  #success_msg{
		  margin-left:150px;
		  color:green;
		  msrgin-top:-150px;
	  }
	  #subjec{
		   width:46%;
	  }
	  </style>
  </body>