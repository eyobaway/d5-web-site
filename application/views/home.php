
<section id="featured-wrapper">
	<div class="container featured">
		<div class="row">
			<div class="featured-description">
				<h1 id="countdown"><span id="days"></span><small> day </small><span id="hours"></span><small> hrs </small><span id="minutes"></span><small> min </small><span id="seconds"></span><small> sec </small></h1>
			</div>
		</div>
	</div>
</section>

</div> <!-- closing the two wrapper div opened in the header - only for the home page -->

<section style="background-color: #f00; color: #fff; padding-top: 10px;">
	<div class="container">
		<div class="row">
			<div class="col-xs-12" style="text-align: center;">
				<p>DUE TO THE RECENT CHEAT EXPLOITS  , SUPPORT KILLSTREAK WILL BE RESTRICTED FOR THE NEXT EVENT.</p>
			</div>
			
		</div>
	</div>
</section>

<section id="about-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-4 dgc-logo hidden-xs hidden-sm">
				<img src="<?php echo base_url(); ?>img/d5.png" alt="D5 Game Con">
			</div>
			<div class="col-sm-12 col-md-8">
				<h1>About D5</h1>

				<p>We are a group of dedicated gamers who want to make the gaming scene bigger. We host multiplayer events twice a month, where people gather to play different games together.</p>
				
				<?php if (isset($login_status) && $login_status == FALSE): ?>
				<div class="row">
					<div class="col-xs-6 dgc-btn">
						<a href="<?php echo base_url()."register"; ?>" class="btn">Join D5</a>
					</div>
					<div class="col-xs-6 dgc-btn">
						<a href="<?php echo base_url()."login"; ?>" class="btn">Login</a>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>


<section id="media-wrapper" class="">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<h2>Previous Events</h2>
			</div>
		</div>

		<div class="row my-slider">
			<ul>
				<li><img src="<?php echo base_url(); ?>img/event/1.jpg" alt="Event" /></li>
				<li><img src="<?php echo base_url(); ?>img/event/2.jpg" alt="Event" /></li>
				<li><img src="<?php echo base_url(); ?>img/event/3.jpg" alt="Event" /></li>
				<li><img src="<?php echo base_url(); ?>img/event/4.jpg" alt="Event" /></li>
				<li><img src="<?php echo base_url(); ?>img/event/5.jpg" alt="Event" /></li>
			</ul>
		</div>

		<div class="row">
			<div class="col-sm-12 center">
				<p><a href="<?php echo base_url(); ?>gallery">Browse the Gallery</a></p>
			</div>
		</div>

	</div>
</section>

	
<!-- test section JS -->s
<script>
	jQuery(document).ready(function($) {
		var $slider = $('.my-slider').unslider({
			autoplay: true,
			arrows: false,
			infinite: true,
			speed:1000,
			delay:5000
		});

		$slider.on('mouseover', function() {
			$slider.data('unslider').stop();
		}).on('mouseout', function() {
			$slider.data('unslider').start();
		});
	});
</script>
<!-- -->

<!-- test section JS -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/countdown.js"></script>

