/*function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	
	var keyword = jQuery('#dir_keyword').val();
	alert(keyword);
	if (keyword.length >= min_length) {
		jQuery.ajax({
			url: wp_autocomplete.ajax_url,
			type: 'POST',
			data: {
				keyword:keyword,
				action: 'dir_autocmp',
			},
			success:function(data){
				jQuery('#directory_list_id').show();
				jQuery('#directory_list_id').html(data);
			}
		});
	} else {
		jQuery('#directory_list_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	jQuery('#dir_keyword').val(item);
	// hide proposition list
	jQuery('#directory_list_id').hide();
} */
/* frontend  echo
'<form action="<?php echo $list_url;?>" method="post" class="search-form">
			<div class="text-conte-search ">
				<h2>Store  Listings</h2>
			</div>
			
			<div class="clearfix wrap-search-ele">
				<fieldset class="col-md-12 no-css-imp">
					<input id="dir_keyword" name="dir_keyword" type="text" class="form-control" placeholder="keyword/phrase" onkeyup="autocomplet()" autocomplete="off">
                    <ul id="directory_list_id"></ul>
				</fieldset>
				<fieldset class="col-md-4 no-css-imp">
					<select name="district" class="form-control">
						<option value="" selected="selected" disabled>chhose title</option>
						<?php  $loop = new WP_Query(array(
                          'post_type'=>'post',
                          'posts_per_page'=>'4'
						));
						while($loop->have_posts()):
						$loop->the_post();
							 ?>
						<option value="title" ><?php the_title();?></option>
						
					</select>
				<?php endwhile;?>
				</fieldset>
				
				<fieldset class="col-md-4 no-css-imp">
					<input id="direc_search" type="submit" name="searchdir" class="btn btn-resource btn-block" value="Search">
				</fieldset>
			</div>

		</form>
function directory_autocomplete()
{
	global $wpdb;
	//print_r($wpdb);
	$keyword = $_POST['keyword'];
	
	

	
	$len=strlen($keyword);
	echo $len;
	$backarg=array('post_type'=>'wpsl_stores');

	$loop= new WP_Query(
		$backarg);
	while($loop->have_posts()):
	$loop->the_post();?>
    <?php $strpart=str_split(get_the_title(),$len);
    print_r($strpart);
    $x=strcmp($strpart[0],$keyword);
echo $x;
    if(strcasecmp($strpart[0],$keyword)==0)
    {  echo "nepal";
    $directory_list = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', the_title());
		    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['post_title']).'\')">'.$directory_list.'</li>';	
    }
    die();
	
	endwhile;
}
add_action('wp_ajax_dir_autocmp', 'directory_autocomplete');
add_action('wp_ajax_nopriv_dir_autocmp', 'directory_autocomplete');
function test_scripts(){
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		wp_enqueue_script('jquery');
	wp_register_script('autocomplete', get_template_directory_uri(). '/js/autocomplete.js', '',true);
wp_enqueue_script('autocomplete');
wp_localize_script( 'autocomplete', 'wp_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

}
add_action( 'wp_enqueue_scripts', 'test_scripts' );*/
?><?php
$stoLatLong= array();
$stoID=array();
$info= array();
$x= array("hello","nepal");
$args=array(
    'post_type'=>'wpsl_stores'
	);
$loop = new WP_Query($args);
while($loop->have_posts()):
$loop->the_post();
$sto=get_post_meta($post->ID,'',true);
$stoLatLong[]=array($sto['wpsl_lat'][0],$sto['wpsl_lng'][0]);
$info[]=$sto['wpsl_city'];
print_r($sto);
$stoID[]=get_the_permalink();

$unsearilize = unserialize($sto['wpsl_hours'][0]);



endwhile;

 ?>
<html><head></head>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>


<body onload="getLocation()">
<script>
//geocoder = new google.maps.Geocoder();
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;	
    myx = [];
    myx = [position.coords.latitude, position.coords.longitude];
    setTimeout(function(){ loadmap(); }, 2000);
   sll.push(myx);
    
}
function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}
</script>
<div id="Map" style="width: 921px; height: 329px;">
</div>
<p id="demo"></p>
<script type="text/javascript">
x = document.getElementById("demo");

function loadmap(){
	// //alert(myx);
  sll=<?php  echo json_encode($stoLatLong);?>;
  var city=<?php echo json_encode($info);?>;
  perm=<?php echo json_encode($stoID);?>;
  ////alert(sll);
   city.push(["my location"]);
   perm.push(["404"]);
   alert(perm);
  // //alert(city);
  //alert(myx);
  console.log(sll);
  console.log(city);
  console.log(perm);
    
	var contentstring = [];
	var regionlocation = [];
	var markers = [];
	var iterator = 0;
	var areaiterator = 0;
	var map;
	var infowindow = [];
	geocoder = new google.maps.Geocoder();
	
	$(document).ready(function () {
		setTimeout(function() { initialize(); }, 400);
	});
	
	function calculatePlaces()
{
	prakashArray = [];
	prakashLocation=[];
	
	console.log(myx);
	//console.log(allx);
	for(i = 0; i< sll.length-1   var locations = [
<?php
if (get_field('repeater_office_location')):
    $repeater = get_field('repeater_office_location');
    ?>
    <?php foreach ($repeater as $random_row): ?>
                ['<?php echo $random_row["resolution_phd_office"]; ?>', "<?php echo $random_row['lng_lng_long']; ?>"],
    <?php endforeach; ?>
<?php endif; ?>
    ];; i++)
	{   dis = getDistanceFromLatLonInKm(sll[4][0], sll[4][1], sll[i][0], sll[i][1])
		if(dis<1000)
		{    //alert(dis);
			alert(perm[i]);
			prakashArray.push({'lat': sll[i][0], 'long' : sll[i][1],'myloc':city[i],'stoperm':perm[i]});
			

		}
	}
    for(myobj in prakashArray){
    	console.log(prakashArray[myobj]);
    	//alert(prakashArray[myobj].myloc[0]);
    }
    //alert(prakashArray.length);

	console.log(prakashArray);

	//load the array items in map
}

	function initialize() {           
		infowindow = [];
		markers = [];
		GetValues();
		iterator = 0;
		areaiterator = 0;
		sll.push(myx);

		// //alert(sll);
		region = new google.maps.LatLng(myx[0], myx[1]);
		
		map = new google.maps.Map(document.getElementById("Map"), { 
			zoom: 9,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: region,
		});
		setTimeout(function() { calculatePlaces(); }, 400);
      
		setTimeout(function() { drop(); }, 400);
      
	}
	
	function GetValues() {
		//Get the Latitude and Longitude of a Point site : http://itouchmap.com/latlong.html
		contentstring[0] = "Ahmedabad, Gujarat, India";
		regionlocation[0] = '23.022505, 72.571362';
					
		contentstring[1] = "Gandhinagar, Gujarat, India";
		regionlocation[1] = "23.224820, 72.646377";
		
		contentstring[2] = "Andheri East, Mumbai, india";
		regionlocation[2] = "19.115491, 72.872695";
		
		contentstring[3] = "Pune, india";
		regionlocation[3] = "18.520430, 73.856744";
		
		contentstring[4] = "Chennai, india";
		regionlocation[4] = "13.082680, 80.270718";
		
		contentstring[5] = "Visakhapatnam, Andhra Pradesh, india";
		regionlocation[5] = "17.686816, 83.218482";
		
	}
		   
	function drop() {
		
		for (var i = 0; i < prakashArray.length; i++) {

              
			setTimeout(function() {
				addMarker();
			}, 800);
			/*setTimeout(function() {
				info(i);
			}, 800);*/
		}
	}
 
	function addMarker() {
		//var address = contentstring[areaiterator];
		
				var address = prakashArray[areaiterator].myloc[0];
				
				if(areaiterator==prakashArray.length-1){
		var icons = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';}
		
        template = prakashArray[areaiterator].lat;
        //alert(template);
        
		//var templong = sll[areaiterator].split(',')[1];
		 templong = prakashArray[areaiterator].long;
		

		var temp_latLng = new google.maps.LatLng(template, templong);
		markers.push(new google.maps.Marker(
		{
			position: temp_latLng,
			map: map,
			icon: icons,
			draggable: false
		}));            
		iterator++;
		info(iterator);
		areaiterator++;
	}
 
	function info(i) {
		//alert(prakashArray[i-1].stoperm);
		//var mycontent =prakashArray[i-1].myloc[0]+'('+prakashArray[i-1].lat+','+prakashArray[i-1].long+')'+
			//'< a hef="'+prakashArray[i-1].stoperm+'">click here</a>';
			var mycontent= '<div id="content" style="width:400px; background-color:red;">' +'<a href="'+prakashArray[i-1].stoperm+'"'+'>'+'hello'+'</a>'+'</br>'

                'My Text comes here' + 
                '</div>';
		infowindow[i] = new google.maps.InfoWindow({

			content: mycontent,
			maxwidth:300
		});
		infowindow[i].content = mycontent;
		google.maps.event.addListener(markers[i - 1], 'click', function() {
			for (var j = 1; j < prakashArray.length + 1; j++) {
				infowindow[j].close();
			}
			infowindow[i].open(map, markers[i - 1]);
		});
	}
}
</script>
</body>
</html>
ul.sum-menu
{
    z-index:1000 !important;
}
