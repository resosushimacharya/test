<p class="email_date" style="float:right"><?php echo date('D/M/Y, H:i:s')?></p>
<p>Dear Admin,</p>
<p>The Following product enquiry was received from the website on <?php echo date('D/M/Y, H:i:s')?>.
<table class="cc_edm_table">
	<tr>
    	<td>Name</td>
        <td><?php echo $first_name.' '.$last_name;?>
    </tr>
	<tr>
    	<td>Email</td>
        <td><?php echo $emailcheck;?>
    </tr>
	<tr>
    	<td>Contact Number</td>
        <td><?php echo $phono;?>
    </tr>
	<tr>
    	<td>State</td>
        <td><?php echo strtoupper($data['cc_state_type']);?>
    </tr>
	<tr>
    	<td>Nearest Store</td>
        <td><?php echo ucwords(strtolower($data['cc_store_name']));?>
    </tr>
	<tr>
    	<td>Comments/enquiries</td>
        <td><?php echo $data['cc_message'];?>
    </tr>
</table>