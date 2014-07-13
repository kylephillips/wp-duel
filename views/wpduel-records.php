<div class="wpduel-records">
	<ul>
		<?php foreach ( $this->records as $record ) : ?>
		<li>
			<strong><?php echo $record['title']; ?></strong>
			<span><?php echo $record['win_ratio']; ?>%</span>
		</li>
		<?php endforeach; ?>
	</ul>
	<div class="wpduel-pagination"><?php echo $this->pagination; ?></div>
</div>