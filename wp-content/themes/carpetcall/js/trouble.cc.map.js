
if(typeof startLatlng=="undefined"){
var startLatlng="-27.665846,153.124777";
};

wpslSettings.autoLocate = autoCurrentLoc.curr_loc;
if(autoCurrentLoc.curr_loc==="1"){
	delete(wpslSettings.geoLocationTimout);
	wpslSettings.geoLocationTimout = "1000000";

}
delete(wpslSettings.autolaod);
wpslSettings.startLatlng =startLatlng;

//console.log(wpslSettings);






