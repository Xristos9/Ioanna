<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Upload</title>
</head>
<body>
	<div class="scrollmenu">
		<a href="adminHome.php">Home</a>
		<a class="active" href="adminUpload.php">Upload</a>
		<a href="adminCharts.php">Charts</a>
		<a href="adminInfo.php">Account Managment</a>
		<a href="logout.php">Logout</a>
	</div>
	<div class="page-wrapper">

		<div class="showcase">
			<div class="form">
				<form class="showcase-form">
					<div class="inner">
						<div class="file-upload">
							<div class="file-upload-select">
								<div class="file-select-button" >Choose File</div>
							<div class="file-select-name">No file chosen...</div> 
							<input type="file" name="file-upload-input" id="file-upload-input" accept=".json" onchange="readFile(this)">
							</div>
						</div>
					</div>
					<div class="btn">
						 <button type="button" id="inputGroupFileAddon04" >Upload to Server</button> 
					</div>
				</form>
			</div>
		</div>
		<div class="destory-btn">
			<button onclick="empty()">Nuke server</button>
		</div>
		<div class="loaderdiv">
			<span id="loader"></span>
		</div>
	</div>

	<!-- Footer -->
	<?php include "footer.php";?>
	<script>
		hideLoader()
		let fileInput = document.getElementById("file-upload-input");
		let fileSelect = document.getElementsByClassName("file-upload-select")[0];

		fileSelect.onclick = function() {
			fileInput.click();
		}
		fileInput.onchange = function() {
			let filename = fileInput.files[0].name;
			let selectName = document.getElementsByClassName("file-select-name")[0];
			selectName.innerText = filename;

			const file = new FileReader()
			file.readAsText(fileInput.files[0])
			console.log(file)

			file.onload = function(e) {
				const data = JSON.parse(e.currentTarget.result)
				console.log(data)

				let upload = []


				for(var i in data){
					stuff = {}

					if(data[i].rating == undefined || data[i].rating_n == undefined){
						stuff.rating = 0
						stuff.rating_n = 0
					}else{
						stuff.rating = data[i].rating
						stuff.rating_n = data[i].rating_n
					}

					stuff.day = []
					stuff.data = []
					stuff.id = data[i].id
					stuff.name = data[i].name
					stuff.address = data[i].address
					stuff.lat = data[i].coordinates.lat
					stuff.lng = data[i].coordinates.lng

					stuff.types = data[i].types.toString()

					for (var j in data[i].populartimes){
						stuff.day.push(data[i].populartimes[j].name)
						stuff.data.push(data[i].populartimes[j].data)
					}

					upload.push(stuff)

				}
				console.log(upload)

				document.getElementById("inputGroupFileAddon04").addEventListener("click", function() {
					showLoader()
					$.ajax({
						url: "uploadInsert.php",
						type: "POST",
						// dataType: 'json',
						data: {data:JSON.stringify(upload)},
						success: function(data) {
							console.log(data)
							if(data == 1){
								hideLoader()
								alert('Success, File uploaded!')
							}
						}
					})
				})
			}

			file.onerror = function() {
				console.log(reader.error);
			};
		}

		function showLoader(){
			var loader = document.getElementById("loader");
			loader.style.display = 'block';
		}

		function hideLoader(){
			var loader = document.getElementById("loader");
			loader.style.display = 'none';
		}

		function empty(){
			if (confirm("Are you sure? You won't be able to reverce this")) {
				console.log("Accepted")
				const ajax = $.ajax({
					url: "delete.php",
					type: "POST",
					data: {boolval:1},
					success: function(data) {
						console.log(data)
						if(data== 11){
							alert('Success, Your sever is nuked!')
						}else if(data == 13 || data == 31 || data == 33 || data == 2){
							alert('Error, Something went wrong!')
						}
						
					}
				})
			} else {
				console.log("Declined")
			}
		}
	</script>
</body>
</html>