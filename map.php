<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Home</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
		integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
		crossorigin="" />
	<link rel="stylesheet" href="Leaflet.AnimatedSearchBox.css">
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
		integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
		crossorigin=""></script>
	<script src="https://cdn.jsdelivr.net/npm/fuse.js@5.0.10-beta/dist/fuse.min.js"></script>
	<script src="Leaflet.AnimatedSearchBox.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
	<div class="scrollmenu">
		<a class="active" href="map.php">Home</a>
		<a href="declare.php">Declare Case</a>
		<a href="stats.php">Stats</a>
		<a href="info.php">Account Managment</a>
		<a href="logout.php">Logout</a>
	</div>

			<!-- Showcase -->
	<div class="showcase">
		<div class="form">
			<form class="showcase-form">
				<div class="inner">
					<label>Which store did you visit?</label>
					<select id="store" class="form-select" aria-label="Default select example">
						<option selected>Choose store</option>
					</select>
				</div>
				<div class="inner">
					<label>How many people were in the store?</label>
					<input type="number" id="people" min="0" placeholder=""/>
				</div>
				<div class="btn">
					<button type="button" id="submit">Submit</button>
				</div>
			</form>
		</div>
	</div>


		<div id="map"></div>


		<!-- Footer -->
	<?php include 'footer.php'; ?>
<script>

	// topiki wra
	var currentdate = new Date();
	var day = currentdate.toLocaleString('en-us', {
		weekday: 'long'
	});

	// eisagwgi xarti
	var map = L.map('map', {
		zoomControl: false
	}).setView([51.505, -0.09], 5);
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	// HTML Geolocation API
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showMarker);
	} else {
		alert('Error, Geolocation is not supported by this browser!')
	}

	// arxikopoihsh icons
	const icon1 = L.icon({
		iconUrl: 'icons/icon1.png',
		iconSize: [38, 38],
		iconAnchor: [20, 0]
	});
	const icon2 = L.icon({
		iconUrl: 'icons/icon2.png',
		iconSize: [38, 38],
		iconAnchor: [20, 0]
	});
	const icon3 = L.icon({
		iconUrl: 'icons/icon3.png',
		iconSize: [38, 38],
		iconAnchor: [20, 0]
	});

	function showMarker(p) {
		// eisagwgi tis topothesias to xristi
		var userPosition = L.marker([p.coords.latitude, p.coords.longitude]).addTo(map)
		userPosition.bindPopup("You are here");
		map.setView([p.coords.latitude, p.coords.longitude], 13)

		// eisagogi drop down menu
		$.ajax({
			url: 'mapSelect.php',
			method: 'GET',
			dataType: 'json',
			success: function(data){
				var values = [];
				// console.log(data)
				for(let i in data){
					if (getDistance(p.coords.latitude, p.coords.longitude, data[i].lat, data[i].lng) <= 20000000){
						values.push(data[i].name)
					}
				}

				for (let i in values){
					var option = document.createElement("option");
					option.value = i;
					option.text = values[i].charAt(0) + values[i].slice(1);
					document.getElementById("store").appendChild(option);
				}

				// document.getElementById("container").appendChild(label).appendChild(select);

				document.getElementById('submit').onclick = function(){
					var s = document.getElementById("store");
					var p = document.getElementById("people");
					if(s.value == "Choose store"){
						alert('Error, Please select a store!')
					}else if(p.value == ""){
						alert('Error, How many people were at the store?')
					}else{
						// console.log(p.value)
						var store = data[s.value]
						var estimation = p.value
						var marker = L.marker(L.latLng(data[s.value].lat, data[s.value].lng)).addTo(map)
						marker.bindPopup("Name: '" + data[s.value].name + "'<br> Address: " + data[s.value].address)
						map.setView([data[s.value].lat, data[s.value].lng], 20)

						console.log(store)
						$.ajax({
							url: 'mapInsert.php',
							method: 'POST',
							// dataType: 'json',
							data:{key: store,estimation: estimation},
							success: function(data){
								console.log(data)
								if(data == 'Records inserted successfully.'){
									alert('Success')
									p.value=''
									s.value='Choose store'

								}
							}
						})
					}
				}
			}
		})
		// telos drop down menu
	}

	// arxi searchbar
	const stores = $.ajax({
		url: 'mapBack.php',
		method: 'GET',
		dataType: 'json',
		success: function(data){
			// console.log(data)
		}
	})

	stores.done(searchResult)

	function searchResult(res){

		// kouti anazitisis
		storeNames = []
		for(let i=0; i<res.length; i=i+7){
			storeNames.push(res[i].name)
		}
		// console.log(storeNames)
		var searchbox = L.control.searchbox({
			position: 'topright',
			expand: 'left',
			width: '450px',
			autocompleteFeatures: ['setValueOnClick']
		}).addTo(map)

		var fuse = new Fuse(storeNames, {
			shouldSort: true,
			threshold: 0.6,
			location: 0,
			distance: 100,
			minMatchCharLength: 1
		});

		searchbox.onInput("keyup", function (e) {
			if (e.keyCode == 13) {
				search();
			} else {
				var value = searchbox.getValue();
				if (value != "") {
					var results = fuse.search(value);
					searchbox.setItems(results.map(res => res.item).slice(0, 5));
				} else {
					searchbox.clearItems();
				}
			}
		});

		searchbox.onButton("click", search);

		function search() {
			var value = searchbox.getValue();

			var info = []

			for(var i in res){
				if(res[i].name == value && res[i].day == day){
					info.push(res[i])
					console.log(value)
				}
			}
			// console.log(info)

			pop = round(info[0].populartimes)

			if (pop >= 0 && pop <= 32) {
				var marker = L.marker(L.latLng(info[0].lat, info[0].lng), {icon: icon1}).addTo(map)
			} else if (pop >= 33 && pop <= 65) {
				var marker = L.marker(L.latLng(info[0].lat, info[0].lng), {icon: icon2}).addTo(map)
			} else if (pop >= 66) {
				var marker = L.marker(L.latLng(info[0].lat, info[0].lng), {icon: icon3}).addTo(map)
			} else {
				var marker = L.marker(L.latLng(info[0].lat, info[0].lng)).addTo(map)
			}

			marker.bindPopup("Name: '" + info[0].name + "'<br> Address: " + info[0].address + "<br>Traffic: " + Math.round(round(info[0].populartimes)));
			map.setView([info[0].lat, info[0].lng], 20);


			function round(data){
				let estimate = [];
				estimate.push(parseInt(data[currentdate.getHours()]), parseInt(data[currentdate.getHours() + 1]), parseInt(data[currentdate.getHours() + 2]));
				return estimate.reduce((a, b) => a + b)/3
			}

			setTimeout(function () {
				searchbox.hide();
				searchbox.clear();
			}, 600);
		}
	}
	//telos searchbar

	// euresi apostasis
	function getDistance(lat1, lon1, lat2, lon2) {
		var R = 6371; // Radius of the earth in km
		var dLat = deg2rad(lat2 - lat1); // deg2rad below
		var dLon = deg2rad(lon2 - lon1);
		var a =
			Math.sin(dLat / 2) * Math.sin(dLat / 2) +
			Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
			Math.sin(dLon / 2) * Math.sin(dLon / 2);
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
		var d = R * c; // Distance in km
		return parseInt(d * 1000);
	}

	function deg2rad(deg) {
		return deg * (Math.PI / 180)
	}

</script>
</body>
</html>