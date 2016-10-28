<tr>
    <td colspan="3">
      <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="30"></td>
          <td width="540">
            <table width="540" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              <tr>
                <td>
                  <p style="font-size: 12px; text-align: right;">Date: <?php echo date('d/m/Y, H:i:s')?></p>
                </td>
              </tr>
              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              <tr>
                <td>
                  <p>Dear Admin,</p>
                  <p>The following product enquiry was received from the website on <?php echo date('d/m/Y, H:i:s')?></p>
                </td>
              </tr>

              <tr>
                <td colspan="3" height="20"></td>
              </tr>
              <tr>
                <td colspan="3">
                  <table width="540" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="140" style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;">Carpets Information:</td>
                        <td style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;"><?php echo $netMessage?></td>
                    </tr>
                    <tr>
                        <td width="140" style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;">Name:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;"><?php echo $first_name.' '.$last_name;?></td>
                      </tr>
                    <tr>
                        <td width="140" style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;">Email:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;"><?php echo $emailcheck;?></td>
                      </tr>
                    <tr>
                        <td width="140" style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;">Contact Number:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;"><?php echo $phono;?></td>
                      </tr>
                    <tr>
                        <td width="140" style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;">State:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;"><?php echo strtoupper($data['cc_state_type']);?></td>
                      </tr>
                    <tr>
                        <td width="140" style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;">Nearest Store:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;"><?php echo ucwords(strtolower($data['cc_store_name']));?></td>
                      </tr>
                    <tr>
                        <td width="140" style="font-size: 12px; font-family:'Arial', sans-serif; padding-bottom: 10px;">Comments/enquiries:</td>
                        <td style="font-size: 12px;  font-family:'Arial', sans-serif;padding-bottom: 10px;"><?php echo $data['cc_message'];?></td>
                    </tr>
                  </table>
                </td>
              </tr>  
              <tr>
                <td colspan="3" height="20"></td>
              </tr>  
            </table>
          </td>
          <td width="30"></td>
        </tr>          
          
          
        </table>
    </td>
  </tr>