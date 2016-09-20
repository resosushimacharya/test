<tr>
    <td colspan="3">
      <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20"></td>
          <td width="560">
            <table width="560" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              <tr>
                <td>
                  <p style="font-size: 12px; text-align: right;"><?php echo date('D/M/Y, H:i:s')?></p>
                </td>
              </tr>
              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              <tr>
                <td>
                  <p>The Following product enquiry was received from the website on <?php echo date('D/M/Y, H:i:s')?></p>
                </td>
              </tr>

              <tr>
                <td colspan="3" height="20"></td>
              </tr>
              <tr>
                <td colspan="3">
                  <table width="560" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="130" style="font-size: 12px; font-family:'Arial', sans-serif; font-weight: 600; color: #15489f;">Rug Information:</td>
                        <td style="font-size: 12px; font-family:'Arial', sans-serif; color: #15489f;">Messahe</td>
                    </tr>
                    <tr>
                        <td width="130" style="font-size: 12px; font-family:'Arial', sans-serif; font-weight: 600; color: #15489f;">Name:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; color: #15489f;"><?php echo $first_name.' '.$last_name;?></td>
                      </tr>
                    <tr>
                        <td width="130" style="font-size: 12px; font-family:'Arial', sans-serif; font-weight: 600; color: #15489f;">Email:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; color: #15489f;"><?php echo $emailcheck;?></td>
                      </tr>
                    <tr>
                        <td width="130" style="font-size: 12px; font-family:'Arial', sans-serif; font-weight: 600; color: #15489f;">Contact Number:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; color: #15489f;"><?php echo $phono;?></td>
                      </tr>
                    <tr>
                        <td width="130" style="font-size: 12px; font-family:'Arial', sans-serif; font-weight: 600; color: #15489f;">State:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; color: #15489f;"><?php echo strtoupper($data['cc_state_type']);?></td>
                      </tr>
                    <tr>
                        <td width="130" style="font-size: 12px; font-family:'Arial', sans-serif; font-weight: 600; color: #15489f;">Nearest Store:</td>
                          <td style="font-size: 12px; font-family:'Arial', sans-serif; color: #15489f;"><?php echo ucwords(strtolower($data['cc_store_name']));?></td>
                      </tr>
                    <tr>
                        <td width="130" style="font-size: 12px; font-family:'Arial', sans-serif; font-weight: 600; color: #15489f;">Comments/enquiries:</td>
                        <td style="font-size: 12px; font-family:'Arial', sans-serif; color: #15489f;"><?php echo $data['cc_message'];?></td>
                    </tr>
                  </table>
                </td>
              </tr>  
              <tr>
                <td colspan="3" height="20"></td>
              </tr>  
            </table>
          </td>
          <td width="20"></td>
        </tr>          
          
          
        </table>
    </td>
  </tr>