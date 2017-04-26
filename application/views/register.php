</div>
<section id="register-wrapper">
	<div class="container">
		<div class="row pull-center">
			<div class="col-sm-12 col-md-8 col-md-offset-2">
				<h2>Register</h2>
				<div>
					<?php 
						if (isset($error_msg)) {
							foreach ($error_msg as $error) {
								echo $error;
							}
						}
					?>
				</div>
				<form class="form-horizontal" method="post" action="<?php // echo esc_url($_SERVER['PHP_SELF']); ?>" name="registrationform">
				    <div class="form-group">
				        <label for="inputEmail" class="control-label col-xs-3">Email</label>
				        <div class="col-xs-9">
				            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
				        </div>
				    </div>
				    <div class="form-group">
				        <label for="inputPassword" class="control-label col-xs-3">Password</label>
				        <div class="col-xs-9">
				            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				        </div>
				    </div>
				   <div class="form-group">
				        <label for="confirmPassword" class="control-label col-xs-3">Confirm Password</label>
				        <div class="col-xs-9">
				            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">
				        </div>
				    </div>
				    <div class="form-group">
				        <label for="inputUsername" class="control-label col-xs-3">Username</label>
				        <div class="col-xs-9">
				            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])) { echo $_POST['username']; } ?>">
				        </div>
				    </div>

				    <hr />

				    <div class="form-group">
				        <label for="inputName" class="control-label col-xs-3">Name</label>
				        <div class="col-xs-4">
				            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value="<?php if(isset($_POST['firstname'])) { echo $_POST['firstname']; } ?>">
				        </div>
				        <div class="col-xs-4">
				            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value="<?php if(isset($_POST['lastname'])) { echo $_POST['lastname']; } ?>">
				        </div>
				    </div>
				    <div class="form-group">
				        <label for="inputUsername" class="control-label col-xs-3">Gamer Name</label>
				        <div class="col-xs-9">
				            <input type="text" class="form-control" id="gamername" name="gamername" placeholder="Gamer Name" value="<?php if(isset($_POST['gamername'])) { echo $_POST['gamername']; } ?>">
				        </div>
				    </div>

				    <div class="form-group">
				        <label for="inputBirthdate" class="control-label col-xs-3">Date of Birth</label>
				        <div class="col-xs-9">
				            <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="" value="<?php if(isset($_POST['birthdate'])) { echo $_POST['birthdate']; } ?>">
				        </div>
				    </div>

				    <div class="form-group">
				        <div class="col-xs-offset-2 col-xs-10">
				            <button type="submit" class="btn btn-primary" name="register" onclick="return regformhash(
				            																		this.form,
				            																		this.form.email,
				            																		this.form.password,
				            																		this.form.confirmpassword,
				            																		this.form.username,
				            																		this.form.firstname,
				            																		this.form.lastname,
				            																		this.form.gamername,
				            																		this.form.birthdate);">Register</button>
				        </div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</section>
