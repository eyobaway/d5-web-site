<section style="background-color: white;">
	<?php if(isset($players)): ?>
		<h1 style="text-align: center;">**************</h1>
		<h1 style="text-align: center;">PRE_ALPHA TEST</h1>
		<h1 style="text-align: center;">**************</h1>
		<h2>List of registered players</h2>
		<ul>
		<?php foreach ($players as $player) {
			echo '<li><a href="' . base_url() . 'players/player/' . $player['player_id'] . '">' . $player['username'] . '</a></li>';
		}
		?>
		</ul>

	<?php endif; ?>
</section>