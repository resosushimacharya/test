$( ".wpsl-gmap-canvas" ).each( function( mapIndex ) {
		var mapId = $( this ).attr( "id" );
console.log(mapIndex);
		//initializeGmap( mapId, mapIndex );
	});
wpslSettings.autoLocate=autoCurrentLoc.curr_loc;

console.log(wpslSettings);
alert($( "#wpsl-gmap" ).length );
