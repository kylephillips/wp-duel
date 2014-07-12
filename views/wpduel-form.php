<?php
/**
* Front-end voting form
*/
?>
<div class="wpduel-form">
	<div class="contenders">
		<div class="contender one active">
			<div>
			<h3><?php echo $duel['contender_one']['title']; ?></h3>
			<?php if ( get_option('wpduel_show_image') == 'yes' ) : ?>
			<img src="<?php echo $duel['contender_one']['image']['src']; ?>" alt="<?php echo $duel['contender_one']['image']['alt']; ?>">
			<?php endif; ?>
			</div>
		</div>
		<div class="vs"><span class="highlightbg">vs</span></div>
		<div class="contender two">
			<div>
			<h3><?php echo $duel['contender_two']['title']; ?></h3>
			<?php if ( get_option('wpduel_show_image') == 'yes' ) : ?>
			<img src="<?php echo $duel['contender_two']['image']['src']; ?>" alt="<?php echo $duel['contender_two']['image']['alt']; ?>">
			<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="wpduel-switch">
		<ul>
			<li class="active"><a href="<?php echo $duel['contender_one']['id']; ?>" data-option="one"><?php echo $duel['contender_one']['title']; ?></a></li>
			<li class="right"><a href="<?php echo $duel['contender_two']['id']; ?>" data-option = "two"><?php echo $duel['contender_two']['title']; ?></a></li>
		</ul>
		<span></span>
	</div>
	<form id="wpduel-form" action="" method="POST">
		<?php wp_nonce_field('wpduel', 'wpduel-nonce'); ?>
		<input type="hidden" name="duel_id" id="duel_id" value="<?php echo $duel['duel_id']; ?>">
		<input type="hidden" name="vote" id="vote" value="<?php echo $duel['contender_one']['id']; ?>">
		<button type="submit" id="wpduel-submit">Vote</button>
	</form>
</div>
<?php //if ( $duel['content'] ) echo $duel['content']; ?>