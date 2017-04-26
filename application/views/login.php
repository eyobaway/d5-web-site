</div>
<section id="login-wrapper">
	<div class="container">
		<div class="row pull-center">
			<div class="col-sm-12 col-md-8 col-md-offset-2">
				<h2>Login</h2>

					<?php if (isset($error_msg)): ?>
					<div class="panel panel-danger">
			    		<div class="panel-heading">
			        		<h3 class="panel-title">ERROR</h3>
			    		</div>
						<?php foreach ($error_msg as $error) {
							echo '<div class="panel-body">' . $error . '</div>';
						}
					endif; ?>
					</div>
				<form class="form-horizontal" method="post" action="<?php // echo esc_url($_SERVER['PHP_SELF']); ?>" name="registrationform">
				    <div class="form-group">
				        <label for="inputEmail" class="control-label col-xs-4">Email</label>
				        <div class="col-xs-4">
				            <input type="email" class="form-control" id="email" name="email" placeholder="Email/Username" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
				        </div>
				    </div>
				    <div class="form-group">
				        <label for="inputPassword" class="control-label col-xs-4">Password</label>
				        <div class="col-xs-4">
				            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				        </div>
				    </div>

				    <hr />

				    <div class="form-group">
				        <div class="col-xs-offset-2 col-xs-10">
				            <button type="submit" class="btn btn-primary" name="register" onclick="return logformhash(
				            																		this.form,
				            																		this.form.email,
				            																		this.form.password);">Login</button>
				        </div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</section>