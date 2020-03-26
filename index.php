<?php # index.php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
session_start();
//check session first
include ('header.php');


if (isset($_SESSION['user_session'])){

}else
{
//header("Location: login-form.php");
}
?>

<div id="map_canvas"></div>
<div id="info"></div>
<br><br><br><br>

<div class="forms">
<div id="form-address" title="Enter address/Zipcode">
<form id="formAddress" style="center">
<input type="textbox" id="address" size="30" maxlength="40"class="text ui-widget-content ui-corner-all"/>
<button id="btnAddress" type="submit" value="search" onClick="codeAddress()" style=" visibility: hidden;"></button> 
</form>
</div>

<button id="searchPlace" class="btn btn-default" style="background-color:#81BEF7; 
color:black;font-weight: bold;">Search</button> 
</div>

<div id="test"></div>
<div id="test2"></div>

<script>
var map = null;
var gmarkers = [];
var places = [];
var destMarkers = [];
var service = null;
var noAutoComplete = true;
var initialService = null;
var myPosition = null;
var barLocation = null;
var placeId = null;
var option = null;
var pList = null;
var myMarker = null;
var geocoder = null;
var rating = $("#rating_pass").val();
var infowindow = new google.maps.InfoWindow({size: new google.maps.Size(150,50)});
var startLoc = null;
var circle = null;

function callback(results, status, pagination) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
 
   for (var i = 0; i < results.length; i++) {
    var id = results[i].place_id;
	var data = $.parseJSON($.ajax({
		type: 'get',
		url: 'getInfo.php',
		data: {placeId: results[i].place_id},
		dataType: "json", 
        async: false
	}).responseText);
	
	createMarker(results[i], data.Users, data.Rating);	
  }   
  console.log("number of bars: " + results.length);
   }
}

function initialize() {
	geocoder = new google.maps.Geocoder();
  
  navigator.geolocation.getCurrentPosition(function(position){
	myPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	startLoc = myPosition;
	map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: myPosition,
    zoom: 15
	});	
	service = new google.maps.places.PlacesService(map);
	
	google.maps.event.addListener(map, "click", function(evt) {
		infowindow.close();
		myMarker.info.close();
  });
   
	 map.addListener('idle', performSearch);
  
  myLocation();
  }); 
      }
      google.maps.event.addDomListener(window, 'load', initialize);
	  
function myLocation(){
	initialService = new google.maps.places.PlacesService(map);  

  	myMarker = new google.maps.Marker({
position: myPosition, map:map, icon: '//maps.google.com/mapfiles/ms/icons/green-dot.png',
  title: 'you'
});
myMarker.info = new google.maps.InfoWindow({
  content: 'you'
});
 google.maps.event.addListener(myMarker, 'click', function() {
  myMarker.info.open(map, myMarker);
  infowindow.close();}); 
}

function performSearch() {
  var request = {
    bounds: map.getBounds(),
    keyword: 'bar',
	types: ['bar']
  };
  
  gmarkers.length = 0;
  places.length = 0;
  
  service.nearbySearch(request, callback);
}

function createMarker(place, users, rating){
	
	var placesList = document.getElementById('places');
    if (place.icon) {
      var image = new google.maps.MarkerImage(
                place.icon, new google.maps.Size(71, 71),
                new google.maps.Point(0, 0), new google.maps.Point(17, 34),
                new google.maps.Size(25, 25));
     } else var image = null;

    var marker=new google.maps.Marker({
        map:map,
        icon: {
      url: 'img/bar2.png'
    },
		title: place.name,
		anchorPoint: new google.maps.Point(-5, -30),
        position:place.geometry.location
    });
	
	var request =  {
          reference: place.reference
    };
     
	
	 
    google.maps.event.addListener(marker,'click',function(){
        service.getDetails(request, function(place, status) {
			//console.log(place);
			
			placeId = place.place_id;			
          if (status == google.maps.places.PlacesServiceStatus.OK) {
			var str;
			if (users > 1){
				str = "people here";
			}else if (users == 0){
				str = "people here";
			} else{
				str = "person here";
			}
            var contentStr = "<div class='contStr' style='font-size:15px;font-family: 'Bree Serif', serif;'><a href="+ place.url + ">" +  place.name + "</a>" + 
			"<br> " + users + " " + str +
			"<br> Fun Level " + rating +			
			"</div>"+
			"<div class='stars'>"+
			"<form action=''>"+
			"<input class='star star-5' id='star-5' type='radio' name='star'/>"+
			"<label class='star star-5' for='star-5'></label>"+
			"<input class='star star-4' id='star-4' type='radio' name='star'/>"+
			"<label class='star star-4' for='star-4'></label>"+
			"<input class='star star-3' id='star-3' type='radio' name='star'/>"+
			"<label class='star star-3' for='star-3'></label>"+
			"<input class='star star-2' id='star-2' type='radio' name='star'/>"+
			"<label class='star star-2' for='star-2'></label>"+
			"<input class='star star-1' id='star-1' type='radio' name='star'/>"+
			"<label class='star star-1' for='star-1'></label>"+
			"</form>"+
			"</div>"+
			"<div class='btnWrapper' style='text-align:center'><button id='btRate' name='btRate' class='btn btn-primary' >Rate</button></div>";
			
            infowindow.setContent(contentStr);
			myMarker.info.close();
            infowindow.open(map,marker);
			
/* place a cirlce around a point	 */
	/* var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: place.geometry.location,
            radius: 50
          }); */
			barLocation = pointInCircle(myPosition, place.geometry.location);
			//document.getElementById("test2").innerHTML = barLocation; //pointInCircle(myPosition, place.geometry.location);
          } 
        });
    }); 
	
    gmarkers.push(marker);	
}

function gotoBar(a){
for (i = 0; i < gmarkers.length; i++){
	if (a.value == gmarkers[i].title){
		console.log(a.value );
		map.setCenter(new google.maps.LatLng(gmarkers[i].position.lat(), gmarkers[i].position.lng()));
		google.maps.event.trigger(gmarkers[i], 'click')		
	}	
	}		
}

function codeAddress() {
	for(i=0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
	
	myMarker.setMap(null);
	var address = document.getElementById('address').value;
		

	geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
	  myPosition = results[0].geometry.location;
      myLocation();
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
  dialog.dialog( "close" );		
}

function pointInCircle(point, center){
    return (google.maps.geometry.spherical.computeDistanceBetween(point, center) <= 50)
}

var dialog, dialog2, form, form2,  address = $("#address");

	//search 
	$(function() {		
		function add() {
			$("#btnAddress").trigger("click");
			 dialog.dialog( "close" );
	}
		
		dialog = $( "#form-address" ).dialog({
      autoOpen: false,
      height: 200,
      width: 350,
      modal: true,
      buttons: {
        "Search": add,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
      }
    });
	
	form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
    });
	
	$( "#searchPlace" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });	
		});
		
	//rate
	$(function() {	
		var $star=0;
		$(document).on("click", "#btRate", function(){
		
		if(!barLocation){
		if( $('#star-5').is(':checked')){
			$star = 5;
		} else if ( $('#star-4').is(':checked')){
			$star = 4;
		} else if ( $('#star-3').is(':checked')) {
			$star = 3;
		} else if ( $('#star-2').is(':checked')) {
			$star = 2;
		} else {
		$star = 1;}
			
		$.ajax({
        type: 'POST',
        url: 'rate.php',
        data: { rating: $star, userLocation: myPosition.lat() + "," + myPosition.lng(), placeId: placeId},
        success: function(response) {
			console.log(response);
         alert(response);
        }
		});	
		}
		else{window.alert("You are not At this bar");}
		
    		
		});	 
	});
</script>
	
<?php
include ('footer.php');
?>