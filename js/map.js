/*
Theme Name: 
Version: 
Author: 
Author URI: 
Description: 
*/
/*	IE 10 Fix*/

(function ($) {
	'use strict';
	
	jQuery(document).ready(function () {

        //Google Map
        var myLatlng = new google.maps.LatLng(39.305, -76.617);
        var mapProp= {
          center: myLatlng,
          zoom: 12,
          styles: [
            {elementType: 'geometry', stylers: [{color: '#ffffff'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#ffffff'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#b5b1b9'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#b5b1b9'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#b5b1b9'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#f4f3ed'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#b5b1b9'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#eeeeee'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#eeeeee'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#b5b1b9'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#dacc98'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#ffffff'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#b5b1b9'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#f4f3ed'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f4f3ed'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#f4f3ed'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#b5b1b9'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#b5b1b9'}]
            }
          ]
        
        };
        var map=new google.maps.Map(document.getElementById("googleMap2"),mapProp);

        var contentString = '<div class="map_content">'+
            '<h3>Health Shine</h3>'+
            '<div>'+
            '<p>We <b>Health Shine</b> always ready for you.</p>'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: myLatlng,
            animation: google.maps.Animation.DROP,
            title:"Hello World!"
        });
        marker.addListener('click', function() {
            if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
                infowindow.open(map, marker);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
                infowindow.open(map, marker);
            }
        });
        // To add the marker to the map, call setMap();
        marker.setMap(map);

 	});
	
})(jQuery);
