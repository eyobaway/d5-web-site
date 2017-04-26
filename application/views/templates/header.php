<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>D5 Game Con</title>

		<!-- Bootstrap -->
		<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">

		<!-- DGC Styles -->
		<link href="<?php echo base_url(); ?>css/main.css" rel="stylesheet">

		<!-- FONT -->
		<!-- <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,400italic' rel='stylesheet' type='text/css'> -->

		<!-- SCRIPTS -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> --> <!-- CDN -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

		<!-- js -->
		<script src="<?php echo base_url(); ?>js/main.js"></script>

		<!-- specific layouts and js -->
		<?php
			if (isset($css)) { load_css($css); }
			if (isset($js)) { load_js($js); }
		?>

		<!-- favicons -->
		<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo base_url(); ?>img/fav/apple-touch-icon-57x57.png" />
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>img/fav/apple-touch-icon-114x114.png" />
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>img/fav/apple-touch-icon-72x72.png" />
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>img/fav/apple-touch-icon-144x144.png" />
		<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo base_url(); ?>img/fav/apple-touch-icon-60x60.png" />
		<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo base_url(); ?>img/fav/apple-touch-icon-120x120.png" />
		<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo base_url(); ?>img/fav/apple-touch-icon-76x76.png" />
		<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo base_url(); ?>img/fav/apple-touch-icon-152x152.png" />
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/fav/favicon-196x196.png" sizes="196x196" />
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/fav/favicon-96x96.png" sizes="96x96" />
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/fav/favicon-32x32.png" sizes="32x32" />
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/fav/favicon-16x16.png" sizes="16x16" />
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/fav/favicon-128.png" sizes="128x128" />
		<meta name="application-name" content="&nbsp;"/>
		<meta name="msapplication-TileColor" content="#FFFFFF" />
		<meta name="msapplication-TileImage" content="<?php echo base_url(); ?>img/fav/mstile-144x144.png" />
		<meta name="msapplication-square70x70logo" content="<?php echo base_url(); ?>img/fav/mstile-70x70.png" />
		<meta name="msapplication-square150x150logo" content="<?php echo base_url(); ?>img/fav/mstile-150x150.png" />
		<meta name="msapplication-wide310x150logo" content="<?php echo base_url(); ?>img/fav/mstile-310x150.png" />
		<meta name="msapplication-square310x310logo" content="<?php echo base_url(); ?>img/fav/mstile-310x310.png" />

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>


		<!-- the section below is for the floating account info at the top -->
		<section id="account" style="display:block;width:180px;height:50px;z-index:1;position:absolute;top:10px;right: 0;">
			<?php if ($login_status): ?>
			<div class="btn-group">
			    <a href="<?php echo base_url() . 'players/player/' . $login_status['player_id']; ?>" class="btn btn-default"><?php echo $login_status['username']; ?></a>
			    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="caret"></span></button>
			    <ul class="dropdown-menu">
			    	<li><a href="<?php echo base_url() . 'players/player/' . $login_status['player_id']; ?>">View account</li>
			    	<li class="divider"></li>
			        <li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
			    </ul>
			</div>
			<?php else: ?>
			<div class="btn-group">
				<a class="btn btn-default" href="<?php echo base_url(); ?>login">Login</a>
			    <a class="btn btn-default" href="<?php echo base_url(); ?>register">Register</a>
			</div>
			<?php endif; ?>
		</section>
		<!-- end of the floating account info -->


		<?php
		// if ( (base_url() . 'index.php' == 'http://localhost' . $_SERVER['PHP_SELF']) || (base_url() . 'index.php/home' == 'http://localhost' . $_SERVER['PHP_SELF']) ) echo '<div id="two-wrapper">';
		?>

		<!-- server testing mode -->
		<?php
		if ( (base_url() . 'index.php' == 'http://localhost' . $_SERVER['PHP_SELF']) || (base_url() . 'index.php/home' == 'http://localhost' . $_SERVER['PHP_SELF']) ) echo '<div id="two-wrapper">';
		?>
		<!-- end of test section -->

		<section id="header-wrapper">
			<!-- header -->
			<header class="navbar">
				<div class="container">
					<div class="navbar-header">
						<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".right-navigation">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="<?php echo base_url(); ?>" class="navbar-brand">
							<img src="<?php echo base_url(); ?>img/logo.png" alt="D5 Game Con" />
						</a>
					</div>
					<nav class="collapse navbar-collapse right-navigation">
						<ul class="nav navbar-nav navbar-right">
							<li><a <?php if ((base_url() . 'index.php') == ('http://localhost' . $_SERVER['PHP_SELF']) || (base_url() . 'index.php/home') == ('http://localhost' . $_SERVER['PHP_SELF'])) { echo 'class="current"'; } ?> href="<?php echo base_url(); ?>">D5</a></li>
							<li><a <?php if ((base_url() . 'index.php/event') == ('http://localhost' . $_SERVER['PHP_SELF'])) { echo 'class="current"'; } ?> href="<?php echo base_url(); ?>event">Events</a></li>
							<li><a <?php if ((base_url() . 'index.php/home/about') == ('http://localhost' . $_SERVER['PHP_SELF'])) { echo 'class="current"'; } ?> href="<?php echo base_url(); ?>/home/about">About Us</a></li>
							<!-- <li><a href="#">Leaderboard</a></li>
							<li><a href="#">Forums</a></li> -->
						</ul>
					</nav>
				</div>
			</header>
		</section>