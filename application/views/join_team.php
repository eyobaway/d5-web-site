<section id="join-team-wrapper">
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1>Join a Team</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<h3>Team Name</h3>
				<?php
					if (isset($teams_list)) {
						foreach ($teams_list as $team) {
							echo '<p><a href="' . base_url() . 'teams/team/' . $team['team_id'] . '">' . $team['team_name'] . '</a></p>';
						}
					}
				?>
			</div>
			<div class="col-xs-4">
				<h3>Members</h3>
				<?php
					if (isset($teams_list)) {
						foreach ($teams_list as $team) {
							echo '<p>' . $team['team_count'] . '/9</p>';
						}
					}
				?>
			</div>
			<div class="col-xs-4">
				<h3>&nbsp;</h3>
				<?php
					if (isset($teams_list)) {
						foreach ($teams_list as $team) {
							if ($team['team_count'] < 9) {
								echo '<p><a href="' . base_url() . 'teams/team/' . $team['team_id'] . '/request">Join</a></p>';
							} else {
								//echo "&nbsp;";
								echo "<p>Full</p>";
							}
						}
					}
				?>
			</div>
		</div>
	</div>

</section>