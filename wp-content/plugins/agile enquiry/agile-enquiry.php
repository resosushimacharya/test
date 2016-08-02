<?php 
/**
 * CSV Exporter bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           CSV Export
 *
 * @wordpress-plugin
 * Plugin Name:       CSV Export
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       exports csvs derrr
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       csv-export
 * Domain Path:       /languages
 */
class CSVExport {

  /**
   * Constructor
   */
  public function __construct() {
    if (isset($_GET['report'])) {

      $csv = $this->generate_csv();
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: private", false);
      header("Content-Type: application/octet-stream");
      header("Content-Disposition: attachment; filename=\"report.csv\";");
      header("Content-Transfer-Encoding: binary");

      echo $csv;
      exit;
    }

// Add extra menu items for admins
    add_action('admin_menu', array($this, 'admin_menu'));

// Create end-points
    add_filter('query_vars', array($this, 'query_vars'));
    add_action('parse_request', array($this, 'parse_request'));
  }

  /**
   * Add extra menu items for admins
   */
  public function admin_menu() {
    add_submenu_page('edit.php?post_type=enquiries','Enquiry Details', 'Export Enquiry Details', 'manage_options', 'enquiry_details', array($this, 'enquiry_details'));
  }

  /**
   * Allow for custom query variables
   */
  public function query_vars($query_vars) {
    $query_vars[] = 'download_report';
    return $query_vars;
  }

  /**
   * Parse the request
   */
  public function parse_request(&$wp) {
    if (array_key_exists('download_report', $wp->query_vars)) {
      $this->download_report();
      exit;
    }
  }

  /**
   * Download report
   */
  public function enquiry_details() {
  
  
    echo '<div class="enquiry-details-csv-page"><h3>Click download to export Enquiry details in CSV</h3>';
    echo '<p><a href="?post_type=enquiries&report=users">Download</a></p></div>';
  }

  /**
   * Converting data to CSV
   */
  public function generate_csv() {
    /*$rows = array (
    array('aaa', 'bbb', 'ccc', 'dddd'),
    array('123', '456', '789'),
    array('"aaa"', '"bbb"')
);*/
$args = array(
    'post_type'=>'enquiries',
    'posts_per_page'=>'-1',
    'post_status' => 'publish'
   );
$loop = new WP_Query($args);

$arrayCsv = array();
$arrayCsv[] = array('Name','Email Address','Phone','Admin Email','Enquiry Type','Enquiry Date','State','Store','Message');
 

  while($loop->have_posts()):
            $loop->the_post();
                      $title = get_the_title();
                      $useremail = get_post_meta($loop->post->ID,'email',true);
                      $phone   = get_post_meta($loop->post->ID,'phone',true);
                      $adminemail   = get_post_meta($loop->post->ID,'admin_email',true);

                        $enquirytype = get_post_meta($loop->post->ID,'enquiry_type',true);
                        $enquirydatecontact = get_post_meta($loop->post->ID,'enquiry_date_contact',true);
                        $state =get_post_meta($loop->post->ID,'enquiry_date_contact',true);
                        $store = get_post_meta($loop->post->ID,'store',true);
                        $message= strip_tags(get_the_content()," ");
                      
                      //$message = apply_filters('custom_csv_escape_tag',$message);
                   $arrayCsv[] = array( $title,
                                        $useremail,
                                       
                                        $phone,
                                        $adminemail,
                                        $enquirytype,
                                        $enquirydatecontact,
                                        $state,
                                        $store,
                                        $message
                                       
                                      );                              
                            
                                                   
                           
                            

            

    endwhile;


 $csv_output = '';

foreach($arrayCsv as $check):
   foreach($check as $r):
          $csv_output .=$r.",";
    endforeach;

     $csv_output .= "\n";
endforeach;
   
   

    return $csv_output;
  }

}

// Instantiate a singleton of this plugin
add_action('init' ,'custom_csv_export_function');
function custom_csv_export_function(){
  $csvExport = new CSVExport();

}
add_filter('custom_csv_escape_tag','myclean',10,1);
  function myclean($txt) {
                                        $txt=preg_replace("{(<br[\\s]*(>|\/>)\s*){2,}}i", "<br /><br />", $txt);
                                        $txt=preg_replace("{(<br[\\s]*(>|\/>)\s*)}i", "<br />", $txt);
                                        return $txt;
                                    }