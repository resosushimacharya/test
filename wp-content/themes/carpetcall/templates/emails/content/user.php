<tr>
  <td colspan="3">
    <table width="600" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3" height="10"></td>
      </tr>
      <tr>
        <td width="20"></td>
        <td width="560">
          <p style="font-size: 12px; text-align: right;"><?php echo date('d/m/Y, H:i:s')?></p>
        </td>
        <td width="20"></td>
      </tr>
      <tr>
        <td colspan="3" height="10"></td>
      </tr>
      <tr>
        <td width="20"></td>
        <td colspan="560">
          <p class="email_greeting">Dear, <?php echo $first_name.' '.$last_name?></p>
          <p>Thank you for your query. One of our staff members will get back to you shortly.</p>
          <p>Please <a href="<?php echo home_url();?>">click here</a> to return to <a href="<?php echo home_url();?>">homepage</a></p>
        </td>
        <td width="20"></td>
      </tr>
      <tr>
        <td colspan="3" height="10"></td>
      </tr>
    </table>
  </td>
</tr>