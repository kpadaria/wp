//script for range slider


  
  //search script
  $( document ).ready(function() {
   $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 1,
      max: 1000,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		$( "#min_price" ).html( ui.values[ 0 ] );
		$( "#max_price" ).html( ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
	  $( "#min_price" ).html(  $( "#slider-range" ).slider( "values", 0 ) );
	  $( "#max_price" ).html(  $( "#slider-range" ).slider( "values", 1 ));
  } );
  });