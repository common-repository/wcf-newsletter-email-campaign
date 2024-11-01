<script>
$(document).ready( function () {
    $('#wcf_campaign_list').DataTable();
} );
</script>
<div style="margin-top:25px;">
<h3>WCF Campaign List</h3>
</div>
<?php
		  global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			$table_camp_list = $wpdb->prefix . 'wcf_camp_list';
			 $camp_data = "SELECT date, subject, message, recipient_type FROM $table_camp_list";
			 $camp_data_list = $wpdb->get_results($camp_data);
			 
	 
?>
		<div class="container" style="max-width:100%;">
				<table id="wcf_campaign_list" class="display" style="width:100%">
					<thead>
						<tr>
							<th>Sr.No.</th>
							<th>Date</th>
							<th>Title</th>
							<th>Message</th>
							<th>Recipients Type</th>
							
						</tr>
					</thead>
					<tbody>
					<?php
				   $i=1;
    
			   foreach ( $camp_data_list as $camp_details ){  
				$date= $camp_details->date;
				$title =$camp_details->subject;
				$message= $camp_details->message;
				$emails = $camp_details->recipient_type;
 
				 
					?>
					
					  <tr>
						<td><?php echo esc_html($i); ?></td>
						<td><?php echo esc_html($camp_details->date); ?></td>
						<td><?php echo esc_html($camp_details->subject); ?></td>
						<td><?php echo esc_html($camp_details->message); ?></td>
						<td><?php echo esc_html($camp_details->recipient_type); ?></td>
					  </tr>
					
				   <?php $i++; } ?>
				   </tbody>
				</table>
		</div>
