<div class="wpduel-results">
	<?php if ( $this->vote ) : ?>
	<h1>Your Vote for <?php echo $this->results->vote; ?> has been cast!</h1>
	<?php endif; ?>
	<ul>
		<li>
			<h3><?php echo $this->results->contender_one['title']; ?></h3>
			<?php if ( get_option('wpduel_show_image') == 'yes' ) : ?>
			<img src="<?php echo $this->results->contender_one['image']; ?>" alt="<?php echo $this->results->contender_one['title']; ?>">
			<?php endif; ?>
			<p><?php echo $this->results->contender_one['percentage']; ?>%</p>
		</li>
		<li>
			<h3><?php echo $this->results->contender_two['title']; ?></h3>
			<?php if ( get_option('wpduel_show_image') == 'yes' ) : ?>
			<img src="<?php echo $this->results->contender_two['image']; ?>" alt="<?php echo $this->results->contender_two['title']; ?>">
			<?php endif; ?>
			<p><?php echo $this->results->contender_two['percentage']; ?>%</p>
		</li>
	</ul>
</div>
<?php if ( !is_singular('duel') ) : ?>
<button class="wpduel-button" onclick="location.reload()">Next Duel</button>
<?php endif; ?>