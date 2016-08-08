
var startLatlng;

wpslSettings.autoLocate = autoCurrentLoc.curr_loc;
if(autoCurrentLoc.curr_loc==="1"){


	delete(wpslSettings.geoLocationTimout);
	wpslSettings.geoLocationTimout = "1000000";

}

if(startLatlng==''){
	wpslSettings.startLatlng =startLatlng;
}








