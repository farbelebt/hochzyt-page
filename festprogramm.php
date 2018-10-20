<?php

function festprogramm_anzeigen(){
?><content class="fest_infos">

	<h2>Unser Festprogramm am 18. Mai 2019</h2>
	<br>
	<h3>Trauung:</h3>
	<p>Wir heiraten um 14 Uhr in der Kirche Attiswil, Bachmattstrasse 8, 4536 Attiswil</p>
	
	<br>
	<h3>Apéro und Fototermin:</h3>
	<p>Nach der Trauung ist es nur ein kurzer Fussweg (das Auto stehen lassen) bis zum Restaurant Bären in Attiswil. Es sind alle herzlich zum Apéro eingeladen. Währenddessen findet der Fototermin mit dem Brautpaar und der Hochzeitsgesellschaft statt.</p>
	
	<br>
	<h3>Hochzeitsfest:</h3>
	<p>Geladene Gäste bitten wir, um 17 Uhr im <a href="https://www.kreuz-herzogenbuchsee.ch/de" target="_blank">Restaurant Kreuz</a>, Kirchgasse 1, 3360 Herzogenbuchsee, einzutreffen. Hier feiern wir im wunderschönen historischen Dachstock des Gasthofs.</p>
	
	<br>
	<h3>Beiträge und weitere Informationen zum Fest:</h3>
	<p>Hast du einen Beitrag, eine Idee, eine Überraschung oder ein Anliegen? Dann schreibe bitte mittels <a href="?do=kontaktformular_anzeigen">Kontaktformular</a> an die Trauzeugen.</p>
	
	<br>
	<h3>Übernachtungsmöglichkeiten:</h3>
	<p>Bitte reserviere frühzeitig ein Zimmer z.B. in folgenden Hotels:
		 <ul>
  			<li><a href="https://www.kreuz-herzogenbuchsee.ch/de/hotel" target="_blank"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;Hotel Kreuz Herzogenbuchsee</a></li>
  			<li><a href="http://www.parkhotel-langenthal.ch/de/hotel/" target="_blank"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;Parkhotel Langenthal</a></li>
  			<li><a href="https://www.bnb-wangenried.ch/" target="_blank"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;Bed and Breakfast Wangenried</a></li>
		</ul> 
	</p>

	<br>
	<h3>Geschenke:</h3>
	<p>Da wir (fast) wunschlos glücklich sind, freuen wir uns auf finanziellen Zustupf für zukünftige Anschaffungen, Ausflüge, Ferien etc. Bitte benutze hierfür die Wunschliste. Herzlichen Dank!</p>

	<br>
	<h3>Locations und Parkieren:</h3>
	<p>Siehe Plan unten.</p>

<br>

<div id="map"></div>

<script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
			
			styles: [
            {elementType: 'geometry', stylers: [{color: '#d4d4d4'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#d4d4d4'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#a7a7a7'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#444'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#444'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#7B7B7B'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#bdbdbd'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#666666'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#8A8A8A'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#a7a7a7'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#676767'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#4D4D4D'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#727272'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#464646'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#969696'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#969696'}]
            }
          ],
			
          center: new google.maps.LatLng(47.2220938,7.6732699),
          mapTypeId: 'roadmap'
        });

        var iconBase = 'bilder/';
        var icons = {
          kirche: {
            icon: iconBase + 'map-marker-kirche.png'
          },
          apero: {
            icon: iconBase + 'map-marker-apero.png'
          },
		parkieren: {
            icon: iconBase + 'map-marker-parking.png'
          },
          fest: {
            icon: iconBase + 'map-marker-fest.png'
          }
        };

        var features = [
          {
            position: new google.maps.LatLng(47.2453254,7.6160263),
            type: 'kirche'
          }, {
            position: new google.maps.LatLng(47.2469441,7.613644),
            type: 'apero'
          },
			{
            position: new google.maps.LatLng(47.248586,7.6128835),
            type: 'parkieren'
          },
			{
            position: new google.maps.LatLng(47.1882016,7.7069825),
            type: 'fest'
          }
        ];

        // Create markers.
        features.forEach(function(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map
          });
        });
      }
	
	
</script>

<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&callback=initMap">
</script>

</content>
<?php
}

?>