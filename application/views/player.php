<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

</div>

<section id="player-wrapper">
	<div class="container">
		<div class="row center" id="player-info">
			<div class="col-sm-12">
				<img id="pro-pic" src="<?php echo base_url(); ?>img/genericpro.jpg" />
				<h2><?php echo $player_info['username']; ?></h2>
				<?php if (isset($team_name) && $team_name != '') {
					echo '<h3>';
					if ($player_info['player_id'] == $team_admin_id) {
						echo '<small>Leader of</small> ';
					} else {
						echo '<small>Member of</small> ';
					}
					echo '<a href="' . base_url() . 'teams/team/' . $team_id . '">' . $team_name . '</a></h3>';
				}
				?>
				
			</div>
		</div>
		
		
		<div class="row">
			<?php
				if (isset($admin) && $admin === TRUE) {
					echo '<a href="'. base_url() . 'players/player/' . $player_info['player_id'] . '/edit" style="text-decoration: strikethrough;">Edit Profile</a>';
				}
			?>
		</div>

		<div class="row">
		<hr />
		<?php
			if (isset($team_id) && $team_id != 0) {
				if ($team_admin) {
					echo '<a href="' . base_url() . 'teams/team/' . $team_id . '/disunify">Leave and Disunify Team</a>';
				} else if ($admin) {
					echo '<a href="' . base_url() . 'teams/team/' . $team_id . '/leave">Leave Team</a>';
				}
			} else if ($admin) {
				echo '<a href="' . base_url() . 'teams/create">Create a team</a> <br />';
				echo '<a href="' . base_url() . 'teams/join">Join a team</a>';
			}
		?>
		</div>
		
		
	</div>
</section>