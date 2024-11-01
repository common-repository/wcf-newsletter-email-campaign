<script>
$(document).ready( function () {
    $('#wcf_subscriber_list').DataTable();
} );
</script>
<div style="margin-top:25px;">
<h3>WCF Subscriber List</h3>
</div>
<?php

$args = array(
				'role'    =>  'subscriber',
				'orderby' => 'user_nicename',
				'order'   => 'ASC'
			);
			$users = get_users( $args );
?>
<div class="container" style="max-width:100%;">
<table id="wcf_subscriber_list" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Sr.No.</th>
            <th>Name</th>
			<th>Email</th>
			
        </tr>
    </thead>
	<tbody>
	<?php
    $i=1;
    
   foreach ( $users as $user ){  
    $name= $user->display_name;
    $email =$user->user_email;
 
    ?>
    
      <tr>
        <td><?php echo esc_html($i); ?></td>
        <td><?php echo esc_html($user->display_name); ?></td>
		<td><?php echo esc_html($user->user_email); ?></td>
      </tr>
    
   <?php $i++; } ?>
   </tbody>
</table>
</div>
