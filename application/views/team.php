<section id="team-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">

				<?php if (isset($_SESSION['message'])): ?>
					<div class="panel <?php if($_SESSION['message']['type'] == 'success') { echo 'panel-success'; } else { echo 'panel-danger'; } ?>">
			    		<div class="panel-heading">
			        		<h3 class="panel-title"><?php if($_SESSION['message']['type'] == 'success') { echo 'Success'; } else { echo 'Error'; } ?></h3>
			    		</div>

						<?php echo '<div class="panel-body">' . $_SESSION['message']['content'] . '</div>';
					endif;
					unset($_SESSION['message']); ?>
					</div>

				<?php 
				if (isset($_SESSION['diag'])) { 
					echo '<p>' . $_SESSION['diag'][0] . '</p>'; 
					print_r($_SESSION['diag'][1]);
					unset($_SESSION['diag']);
				} 

				?>

				<?php

					echo '<h1>' . $team_info['team_name'] . '</h1>';


				?>

				<?php if (isset($error_msg) && !empty($error_msg)): ?>
					<div class="panel panel-danger">
			    		<div class="panel-heading">
			        		<h3 class="panel-title">ERROR</h3>
			    		</div>
						<?php foreach ($error_msg as $error) {
							echo '<div class="panel-body">' . $error . '</div>';
						}
					endif; ?>
					</div>

				<h2>Team Members</h2>
				<ol>
				<?php
					foreach ($team_info['team_members'] as $member) {
						$player_info = $this->player_model->get_player_info($member);
						echo "<li>" . $player_info['username'] . " [" . $player_info['gamername'] . "] ";
						if ($admin && ($player_info['player_id'] != $team_info['team_admin'])) {
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . base_url() . "teams/team/" . $team_info['team_id'] . "/remove?id=" . $player_info['player_id'] . "'>Remove</a>";
						}
						echo "</li>";
					}
				?>
				</ol>

				<?php if ($admin): ?>
					<hr />
					<h3>ADMIN TOOLS</h3>
					<p><a href="<?php echo base_url(); ?>teams/team/<?php echo $team_info['team_id']; ?>/delete">Delete Team</a></p>
					<?php
						if (isset($team_info['join_requests'])) {
							echo "<h3>Requests</h3>";
							echo "<ol>";
							foreach ($team_info['join_requests'] as $id => $player) {
								echo "<li>" . $player . "&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . base_url() . "teams/team/" . $team_info['team_id'] . "/join?id=" . $id . "'>Accept</a></li>";
							}
							echo "</ol>";
						}
					?>
				<?php endif; ?>
				
					
			</div>
		</div>
	</div>
</section>