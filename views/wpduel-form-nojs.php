<?php
/**
* Front-end voting form (No JS)
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
	<form id="wpduel-form" action="" method="POST">
		<div class="wpduel-radios">
			<ul>
				<li>
					<label for="choice_one">
					<input type="radio" name="vote" value="<?php echo $duel['contender_one']['id']; ?>" id="choice_one" checked > <?php echo $duel['contender_one']['title']; ?>
					</label>
				</li>
				<li>
					<label for="choice_two">
					<input type="radio" name="vote" value="<?php echo $duel['contender_two']['id']; ?>" id="choice_two" > <?php echo $duel['contender_two']['title']; ?>
					</label>
				</li>
			</ul>
		</div>
		<?php wp_nonce_field('wpduel', 'wpduel-nonce'); ?>
		<input type="hidden" name="duel_id" id="duel_id" value="<?php echo $duel['duel_id']; ?>">
		<button type="submit" id="wpduel-submit">Vote</button>
	</form>
</div>
<?php //if ( $duel['content'] ) echo $duel['content']; ?>