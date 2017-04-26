</div>
<section id="register-wrapper">
	<div class="container">
		<div class="row pull-center">
			<div class="col-sm-12 col-md-8 col-md-offset-2">
				<h2>New Team</h2>

					<?php if (isset($error_msg) && count($error_msg) != 0): ?>
					<div class="panel panel-danger">
			    		<div class="panel-heading">
			        		<h3 class="panel-title">ERROR</h3>
			    		</div>
						<?php foreach ($error_msg as $error) {
							echo '<div class="panel-body">' . $error . '</div>';
						}
					echo '</div>';
					endif; ?>

				<form class="form-horizontal" method="post" action="<?php echo $this->security->xss_clean($_SERVER['PHP_SELF']); ?>" name="registrationform">
				    <div class="form-group">
				        <label for="inputName" class="control-label col-xs-3">Team Name</label>
				        <div class="col-xs-9">
				            <input type="text" class="form-control" id="teamname" name="teamname" placeholder="Team Name" value="<?php if(isset($_POST['teamname'])) { echo $_POST['teamname']; } ?>">
				        </div>
				    </div>

				    <div class="form-group">
				        <label for="teamgame" class="control-label col-xs-3">Team Game</label>
				        <div class="col-xs-9">
				            <select name="teamgame" class="form-control">
				            	<option value="bf3">Battlefield 3</option>
				            	<option value="mw1">Call of Duty: Modern Warfare</option>
				            	<option value="mw3">Call of Duty: Modern Warfare 3</option>
				            </select>
				        </div>
				    </div>

				    <div class="form-group">
				        <label for="inputDesc" class="control-label col-xs-3">Team Description</label>
				        <div class="col-xs-9">
				            <input type="text" class="form-control" id="teamdesc" name="teamdesc" placeholder="Team Description" value="<?php if(isset($_POST['teamdesc'])) { echo $_POST['teamdesc']; } ?>">
				        </div>
				    </div>

				    <div class="form-group">
				    	<div class="row">
				    		<label for="inputName" class="control-label col-xs-3">Add More Members</label>
				    	</div>

				    	<!--- to be replaced -->
				    	<div class="row" id="selectmembers">

				    		<?php
				    		if (isset($_POST['membersstate'])) {
						    	echo $_POST['membersstate'];
						    } else {
						    	
						    	// 1
					    		echo '<div class="col-sm-6 col-sm-offset-3 member-select">';
					    		echo '<select class="form-control" id="sel1" name="sel1">';
					    		echo '<option value=0> - - - - - - </option>'; // null value
					    		// find and iterate through members
					    		foreach ($all_players_id as $player_id => $username) {
					    			echo '<option';
					    			if (isset($_POST['sel1']) && $_POST['sel1'] == $player_id) { echo " selected"; }
					    			echo ' value='.$player_id.'>'.$username.'</option>';
					    		}
							    //
							    echo '</select>';
					    		echo '</div>';

					    		//2
					    		echo '<div class="col-sm-6 col-sm-offset-3 member-select">';
					    		echo '<select class="form-control" id="sel2" name="sel2">';
					    		echo '<option value=0> - - - - - - </option>'; // null value
					    		// find and iterate through members
					    		foreach ($all_players_id as $player_id => $username) {
					    			echo '<option';
					    			if (isset($_POST['sel2']) && $_POST['sel2'] == $player_id) { echo " selected"; }
					    			echo ' value='.$player_id.'>'.$username.'</option>';
					    		}
							    //
							    echo '</select>';
					    		echo '</div>';

					    		// 3
					    		echo '<div class="col-sm-6 col-sm-offset-3 member-select">';
					    		echo '<select class="form-control" id="sel3" name="sel3">';
					    		echo '<option value=0> - - - - - - </option>'; // null value
					    		// find and iterate through members
					    		foreach ($all_players_id as $player_id => $username) {
					    			echo '<option';
					    			if (isset($_POST['sel3']) && $_POST['sel3'] == $player_id) { echo " selected"; }
					    			echo ' value='.$player_id.'>'.$username.'</option>';
					    		}
							    //
							    echo '</select>';
					    		echo '</div>';

					    		// 4
					    		echo '<div class="col-sm-6 col-sm-offset-3 member-select">';
					    		echo '<select class="form-control" id="sel4" name="sel4">';
					    		echo '<option value=0> - - - - - - </option>'; // null value
					    		// find and iterate through members
					    		foreach ($all_players_id as $player_id => $username) {
					    			echo '<option';
					    			if (isset($_POST['sel4']) && $_POST['sel4'] == $player_id) { echo " selected"; }
					    			echo ' value='.$player_id.'>'.$username.'</option>';
					    		}
							    //
							    echo '</select>';
					    		echo '</div>';

					    		// 5
					    		echo '<div class="col-sm-6 col-sm-offset-3 member-select">';
					    		echo '<select class="form-control" id="sel5" name="sel5">';
					    		echo '<option value=0> - - - - - - </option>'; // null value
					    		// find and iterate through members
					    		foreach ($all_players_id as $player_id => $username) {
					    			echo '<option';
					    			if (isset($_POST['sel5']) && $_POST['sel5'] == $player_id) { echo " selected"; }
					    			echo ' value='.$player_id.'>'.$username.'</option>';
					    		}
							    //
							    echo '</select>';
					    		echo '</div>';

					    		// 6
								echo '<div class="col-sm-6 col-sm-offset-3 member-select">';
								echo '<select class="form-control" id="sel6" name="sel6">';
								echo '<option value=0> - - - - - - </option>'; // null value
								// find and iterate through members
								foreach ($all_players_id as $player_id => $username) {
									echo '<option';
									if (isset($_POST['sel6']) && $_POST['sel6'] == $player_id) { echo " selected"; }
									echo ' value='.$player_id.'>'.$username.'</option>';
								}
								//
								echo '</select>';
								echo '</div>';

								// 7
								echo '<div class="col-sm-6 col-sm-offset-3 member-select">';
								echo '<select class="form-control" id="sel7" name="sel7">';
								echo '<option value=0> - - - - - - </option>'; // null value
								// find and iterate through members
								foreach ($all_players_id as $player_id => $username) {
									echo '<option';
									if (isset($_POST['sel7']) && $_POST['sel7'] == $player_id) { echo " selected"; }
									echo ' value='.$player_id.'>'.$username.'</option>';
								}
								//
								echo '</select>';
								echo '</div>';

								// 8
								echo '<div class="col-sm-6 col-sm-offset-3 member-select">';
								echo '<select class="form-control" id="sel8" name="sel8">';
								echo '<option value=0> - - - - - - </option>'; // null value
								// find and iterate through members
								foreach ($all_players_id as $player_id => $username) {
									echo '<option';
									if (isset($_POST['sel8']) && $_POST['sel8'] == $player_id) { echo " selected"; }
									echo ' value='.$player_id.'>'.$username.'</option>';
								}
								//
								echo '</select>';
								echo '</div>';
					    	} ?>

				    	</div>
				    	<!-- end of replaced -->
					</div>

				    <div class="form-group">
				        <div class="col-xs-offset-2 col-xs-10">
				            <button type="submit" class="btn btn-primary" name="register" onclick="return createteam(
				            																		this.form);">Create Team</button>
				        </div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</section>