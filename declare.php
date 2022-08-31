<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Declare case</title>
</head>
<body>
	<div class="scrollmenu">
		<a href="map.php">Home</a>
		<a class="active"  href="declare.php">Declare Case</a>
		<a href="stats.php">Stats</a>
		<a href="info.php">Account Managment</a>
		<a href="logout.php">Logout</a>
	</div>

	<div class="page-wrapper">

		<div class="showcase">
			<div class="form">
				<form class="showcase-form">
					<div class="inner">
						<label>When did you test positive for covid?</label>
						<input type="date" id="covidDate" min="2021-10-01"max="2023-12-31" required>
					</div>
					<div class="btn">
						<button type="button" id="submit" onclick="onSubmit()">Submit</button>
					</div>
				</form>
			</div>
		</div>


	</div>

		<!-- Footer -->
	<?php include "footer.php";?>
	<script>

		const currentDate = new Date();

		function onSubmit(){
			const declareDate = new Date(document.getElementById('covidDate').value)
			// console.log(declareDate)
			const findDate =  $.ajax({
				url: 'declareSelect.php',
				method: 'GET',
				dataType: 'json',
				success: function(data){
					console.log(data)
				}
			})

			findDate.done(checkDate)

			function checkDate(result){
				og = new Date(result[0])
				var future = new Date(og.getTime());
				future.setDate(future.getDate()+14);

				if(declareDate == "Invalid Date"){
					alert('Error, Please input a date!')
				}else if(declareDate> currentDate){
					alert('Error, Please dont select future dates!')
				} else if(declareDate<future && declareDate>=og){
					alert('Error, Please wait 14 days before you can declare again!')
				} else if(declareDate<og){
					alert('Error, You have to choose a date thats after your last declaration!')
				}else{
					var date = declareDate.getFullYear()+'-'+(declareDate.getMonth()+1)+'-'+declareDate.getDate();
					$.ajax({
						url: 'declareBack.php',
						method: 'POST',
						data: { date: date },
						success: function(data) {
							console.log(data)
							alert('Thank You!')
						}
					});
				}
			}
		}

	</script>
</body>
</html>