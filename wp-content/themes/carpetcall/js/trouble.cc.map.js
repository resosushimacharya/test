 $( ".wpsl-gmap-canvas" ).each( function( mapIndex ) {
		var mapId = $( this ).attr( "id" );
		console.log(mapIndex);
		//initializeGmap( mapId, mapIndex );
	});
 console.log(wpslSettings);
if(typeof(wpslSettings)!="undefined")
	wpslSettings.autoLocate=autoCurrentLoc.curr_loc;
alert(wpslSettings.autoLocate);

//alert($( "#wpsl-gmap" ).length );
