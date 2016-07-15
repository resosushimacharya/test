
console.log(wpslSettings);
wpslSettings.autoLocate = autoCurrentLoc.curr_loc;
if(autoCurrentLoc.curr_loc==="1"){
	delete(wpslSettings.geoLocationTimout);
	wpslSettings.geoLocationTimout = "1000000";
}

console.log(wpslSettings);




