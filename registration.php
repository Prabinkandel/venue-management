<?php
	include_once("header.php");
	include_once("Database/connect.php");
	@session_start();

	if(isset($_POST['submit'])) {
		$count = "";
	 	$name  = $_POST['nm'];
	  	$surnm = $_POST['surnm'];
	    $unm   = $_POST['unm'];
	 	$email = $_POST['email'];
	 	$pswd  = $_POST['pswd'];
	 	$mo    = $_POST['mo'];
	    $gen   = $_POST['gen'];
	    $adrs  = $_POST['adrs'];

	  	$q = mysqli_query($conn, "SELECT unm FROM registration WHERE unm = '$unm'");
		if(mysqli_num_rows($q) > 0) {
			echo "<script> alert('Username already exists');</script>";	
		} else {
			// ✅ Proper insert with all fields
			$qry = mysqli_query($conn, "INSERT INTO registration (nm, surnm, unm, email, pswd, mo, gen, adrs)
				VALUES ('$name', '$surnm', '$unm', '$email', '$pswd', '$mo', '$gen', '$adrs')");

			if($qry) {
				$qry1 = mysqli_query($conn, "SELECT id FROM registration WHERE unm='$unm'");
				while($row = mysqli_fetch_row($qry1)) {
					$qry2 = mysqli_query($conn, "INSERT INTO login VALUES(NULL, '$unm', '$pswd')");
					if($qry2) {
						echo "<script> alert('Please login to your account');</script>";
						echo "<script> window.location.assign('login.php');</script>";	
					}		
				}
			}
		}
	}
?>

<div class="banner about-bnr">
	<div class="container"></div>
</div>

<div class="codes">
	<div class="container"> 
		<h2 class="w3ls-hdg" align="center">Registration Form</h2>

		<div class="grid_3 grid_4">
			<div class="tab-content">
				<div class="tab-pane active" id="horizontal-form">
					<form class="form-horizontal" action="" method="post" name="reg" onsubmit="return validate(this)">
						
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" pattern="[A-Za-z\s]{2,30}" title="Only letters" name="nm" placeholder="Name" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Surname</label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" name="surnm" pattern="[A-Za-z\s]{2,30}" placeholder="Surname" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" name="unm" placeholder="Username" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-8">
								<input type="email" class="form-control1" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Enter valid email" placeholder="Email" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control1" name="pswd"
								pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
								title="At least 1 number, 1 uppercase, 1 lowercase, and 8+ characters" placeholder="Password" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Mobile</label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" name="mo" pattern="[7-9]{1}[0-9]{9}" title="10-digit mobile starting with 7-9" maxlength="10" placeholder="Mobile Number" required>
							</div>
						</div>

						<!-- ✅ New Gender Field -->
						<div class="form-group">
							<label class="col-sm-2 control-label">Gender</label>
							<div class="col-sm-8">
								<select name="gen" class="form-control1" required>
									<option value="">Select Gender</option>
									<option value="0">Male</option>
									<option value="1">Female</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Address</label>
							<div class="col-sm-8">
								<textarea name="adrs" cols="50" rows="4" class="form-control1" required></textarea>
							</div>
						</div>

						<div class="contact-w3form" align="center">
							<input type="submit" name="submit" value="SEND">
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once("footer.php"); ?>
