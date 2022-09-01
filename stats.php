<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Stats</title>
</head>
<body>
	<div class="scrollmenu">
		<a href="map.php">Home</a>
		<a href="declare.php">Declare Case</a>
		<a class="active" href="stats.php">Stats</a>
		<a href="info.php">Account Managment</a>
		<a href="logout.php">Logout</a>
	</div>

	<div class="page-wrapper">
		<div class="grid">
			<div class="one">
				<table id="html-data-table">
					<tr>
						<th>Covid Declaration Dates</th>
					</tr>
				</table>
			</div>
			<div class="two">
				<table id="html-data-table2">
					<tr>
						<th>Visited Stores</th>
						<th>Date</th>
					</tr>
				</table>
			</div>
			<div class="three">
				<table id="html-data-table3">
					<tr>
						<th>Stores Were There Was Reported Covid Case</th>
						<th>Date</th>
					</tr>
				</table>
			</div>
		</div>
	</div>
			<!-- Footer -->
			<?php include 'footer.php'; ?>

	<script>

		window.onload = function stats(){

			const ajax =  $.ajax({
				url: 'statsSelect1.php',
				method: 'GET',
				dataType: 'json',
				success: function(data){
					console.log(data)
				}
			})

			ajax.done(dates)

			function dates(result){
				const mytable = document.getElementById("html-data-table");

				result.map((date) => {
				let newRow = document.createElement("tr");
				let cell = document.createElement("td");
				cell.innerText = date;
				newRow.appendChild(cell);
				mytable.appendChild(newRow);
				});
			}


			const ajax2 =  $.ajax({
				url: 'statsSelect2.php',
				method: 'GET',
				dataType: 'json',
				success: function(data){
					console.log(data)
				}
			})
	
			ajax2.done(findDates)
	
			function findDates(result){
				const mytable2 = document.getElementById("html-data-table2");

				result.forEach((store) => {
				let newRow = document.createElement("tr");
				Object.values(store).forEach((value) => {
					let cell = document.createElement("td");
					cell.innerText = value;
					newRow.appendChild(cell);
				});
				mytable2.appendChild(newRow);
				});
			}
	
			const ajax3 =  $.ajax({
				url: 'statsSelect3.php',
				method: 'GET',
				dataType: 'json',
				success: function(data){
					console.log(data)
				}
			})
	
			ajax3.done(covid)
	
			function covid(result){
				const mytable3 = document.getElementById("html-data-table3");

				result.map((store) => {
				let newRow = document.createElement("tr");
				Object.values(store).forEach((value) => {
					let cell = document.createElement("td");
					cell.innerText = value;
					newRow.appendChild(cell);
				});
				mytable3.appendChild(newRow);
				});
	
			}
		}

	</script>
</body>
</html>