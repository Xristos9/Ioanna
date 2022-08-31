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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="Leaflet.AnimatedSearchBox.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
		integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
		crossorigin=""></script>
	<script src="https://cdn.jsdelivr.net/npm/fuse.js@5.0.10-beta/dist/fuse.min.js"></script>
	<script src="Leaflet.AnimatedSearchBox.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
	<div class="scrollmenu">
		<a href="adminHome.php">Home</a>
		<a href="adminUpload.php">Upload</a>
		<a class="active" href="adminCharts.php">Charts</a>
		<a href="adminInfo.php">Account Managment</a>
		<a href="logout.php">Logout</a>
	</div>
	<div class="page-wrapper">
		<div class="grid">
			<div class="one">
				<canvas id="myChart" width="300" height="300"></canvas>
			</div>
			<div class="two">
				<canvas id="myChart2" width="300" height="300"></canvas>
			</div>
			<div class="three">
				<canvas id="myChart3" width="300" height="300"></canvas>
			</div>
		</div>
	</div>
		<!-- Footer -->
	<?php include 'footer.php'; ?> 

	<script>
		window.onload = function graph(){

			$.ajax({
				url: 'select(a,b,c).php',
				method: 'GET',
				dataType: 'json',
				success: function(data){
					// console.log(data)

					const ctx = document.getElementById('myChart').getContext('2d');
					const myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ['# of Visits', '# of Covid Cases', '# of infectious visits'],
							datasets: [{
								label: 'a,b,c',
								data: data,
								backgroundColor: [
									'rgba(255, 99, 132, 0.2)',
									'rgba(54, 162, 235, 0.2)',
									'rgba(255, 206, 86, 0.2)',
								],
								borderColor: [
									'rgba(255, 99, 132, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(255, 206, 86, 1)',
								],
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								y: {
									beginAtZero: true
								}
							}
						}
					});

				}
			})

			const ajax = $.ajax({
				url: 'select(d).php',
				method: 'GET',
				dataType: 'json',
				success: function(data){
					// console.log(data)
				}
			})

			ajax.done(findDates)

			function findDates(result){
				// console.log(result)
				let array = []
				let array2 = []

				for(let i in result){
					array.push(result[i].split(','))
				}

				for(let i in array){
					for(let j in array[i]){
						array2.push(array[i][j])
					}
				}

				// console.log(array2)

				let duplicates = array2.reduce(function(acc, el, i, arr) {
				if (arr.indexOf(el) !== i && acc.indexOf(el) < 0) acc.push(el); return acc;
				}, []);

				// console.log(duplicates);

				let counts = {};
				array2.forEach((x) => {
					counts[x] = (counts[x] || 0) + 1;
				});

				// console.log(counts)

				const ctx2 = document.getElementById('myChart2').getContext('2d');
				const myChart2 = new Chart(ctx2, {
					type: 'bar',
					data: {
						labels: duplicates,
						datasets: [{
							label: 'd',
							data: counts,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true
							}
						}
					}
				});
			}

			const ajax2 = $.ajax({
				url: 'select(e).php',
				method: 'GET',
				dataType: 'json',
				success: function(data){
					// console.log(data)
				}
			})

			ajax2.done(ere)

			function ere(result){
				// console.log(result)
					let array = []
					let array2 = []
					for(let i in result){
						array.push(result[i].split(','))
					}

					for(let i in array){
						for(let j in array[i]){
							array2.push(array[i][j])
						}
					}

					// console.log(array2)

					let duplicates = array2.reduce(function(acc, el, i, arr) {
					if (arr.indexOf(el) !== i && acc.indexOf(el) < 0) acc.push(el); return acc;
					}, []);

					// console.log(duplicates);

					let counts = {};
					array2.forEach((x) => {
						counts[x] = (counts[x] || 0) + 1;
					});


					// console.log(counts)
					const ctx3 = document.getElementById('myChart3').getContext('2d');
					const myChart3 = new Chart(ctx3, {
						type: 'bar',
						data: {
							labels: duplicates,
							datasets: [{
								label: 'e',
								data: counts,
								backgroundColor: [
									'rgba(255, 99, 132, 0.2)',
									'rgba(54, 162, 235, 0.2)',
									'rgba(255, 206, 86, 0.2)',
									'rgba(75, 192, 192, 0.2)',
									'rgba(153, 102, 255, 0.2)',
									'rgba(255, 159, 64, 0.2)'
								],
								borderColor: [
									'rgba(255, 99, 132, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(255, 206, 86, 1)',
									'rgba(75, 192, 192, 1)',
									'rgba(153, 102, 255, 1)',
									'rgba(255, 159, 64, 1)'
								],
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								y: {
									beginAtZero: true
								}
							}
						}
					});
			}
		}
	</script>
</body>
</html>