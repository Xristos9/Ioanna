<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Account Managment</title>
</head>
<body>
	<div class="scrollmenu">
		<a href="map.php">Home</a>
		<a href="declare.php">Declare Case</a>
		<a href="stats.php">Stats</a>
		<a class="active" href="info.php">Account Managment</a>
		<a href="logout.php">Logout</a>
	</div>
	<div class="page-wrapper">
		<div class="changeGrid">
			<div class="first">
				<div class="mainDiv">
					<div class="cardStyle">
						<form action="" method="post" name="passForm" id="passForm">
							<h2 class="formTitle">Change Password</h2>

							<div class="inputDiv">
								<label class="inputLabel" for="password">Old Password</label>
								<input class="changeInput" type="password" id="op" 	name="oldPassword" required />
							</div>

							<div class="inputDiv">
								<label class="inputLabel" for="password">New Password</label>
								<input class="changeInput" type="password" id="np" 	name="newPassword" required />
							</div>

							<div class="inputDiv">
								<label class="inputLabel" for="confirmPassword"
									>Confirm Password</label
								>
								<input class="changeInput" type="password" id="cnp" 	name="confirmPassword" />
							</div>

							<div class="buttonWrapper">
								<button
									type="passSubmit"
									id="passSubmitButton"
									onclick="cPass()"
									class="submitButton"
								>
								Submit
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="second">
				<div class="mainDiv">
					<div class="cardStyle">
						<form name="nameForm" id="nameForm">
							<h2 class="formTitle">Change Username</h2>

							<div class="inputDiv">
								<label class="inputLabel" for="username">New Username</label>
								<input class="changeInput" type="text" id="nu" 	name="username"	required />
							</div>

							<div class="buttonWrapper">
							  	<button
									type="nameSubmit"
									id="nameSubmitButton"
									onclick="cName()"
									class="submitButton"
								>
								Submit
							  </button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php include "footer.php";?>
	<script>
		function cName() {
			const newn = document.getElementById("nu").value;

			if (newn == "") {
				alert("Please enter the new Username");
				nu.focus();
			} else {
				let upload = $.ajax({
					url: "changeUsername.php",
					method: "POST",
					data: { newUsername: newn },
					success: function (data) {
						console.log(data);
					},error: function (xhr, exception) {
						var msg = "";
						if (xhr.status === 0) {
							msg = "Not connect.\n Verify Network." + xhr.responseText;
						} else if (xhr.status == 404) {
							msg = "Requested page not found. [404]" + xhr.responseText;
						} else if (xhr.status == 500) {
							msg = "Internal Server Error [500]." +  xhr.responseText;
						} else if (exception === "parsererror") {
							msg = "Requested JSON parse failed.";
						} else if (exception === "timeout") {
							msg = "Time out error." + xhr.responseText;
						} else if (exception === "abort") {
							msg = "Ajax request aborted.";
						} else {
							msg = "Error:" + xhr.status + " " + xhr.responseText;
						}
						console.log(msg)
					}
				});
				upload.done(success);
			}

			function success(result) {
				if (result == 0) {
					alert("Your Username has been updated successfully");
				}
			}
		}

		function cPass() {

			let old = document.getElementById("op").value;
			let newp = document.getElementById("np").value;
			let cnewp = document.getElementById("cnp").value;
			console.log(old,newp,cnewp)
			let strongRegex = new RegExp(
				"^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
			);

			if (old == "") {
				alert("Please enter your Old Password");
			} else if (newp == "") {
				alert("Please enter the new Password");
			} else if (cnewp == "") {
				alert("Please Confirm Password");
			} else if (!strongRegex.test(newp)) {
				alert("Upper case, Lower case, Special character and Numeric letter are required in Password");
			} else if (newp != cnewp) {
				alert("Passwords do not Matched");
			} else {
				let upload = $.ajax({
					url: "changePass.php",
					method: "POST",
					data: { oldPassword: old, newPassword: newp },
					success: function (data) {
						console.log(data);
					},error: function (xhr, exception) {
						let msg = "";
						if (xhr.status === 0) {
							msg = "Not connect.\n Verify Network." + xhr.responseText;
						} else if (xhr.status == 404) {
							msg = "Requested page not found. [404]" + xhr.responseText;
						} else if (xhr.status == 500) {
							msg = "Internal Server Error [500]." +  xhr.responseText;
						} else if (exception === "parsererror") {
							msg = "Requested JSON parse failed.";
						} else if (exception === "timeout") {
							msg = "Time out error." + xhr.responseText;
						} else if (exception === "abort") {
							msg = "Ajax request aborted.";
						} else {
							msg = "Error:" + xhr.status + " " + xhr.responseText;
						}
						console.log(msg)
					}
				});
				upload.done(success);
			}

			function success(res) {
				if (res === 0) {
					alert("Your password has been updated successfully");
				} else if (res === 1) {
					alert("Incorrect password");
				}else {
					alert("An unexpected error has occurred");
				}
			}
		}

	</script>
</body>
</html>