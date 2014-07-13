<div class="wpduel-results chart">
	<?php if ( $this->vote ) : ?>
	<h1>Your Vote for <?php echo $this->results->vote; ?> has been cast!</h1>
	<?php endif; ?>
	<ul>
		<li style="color: <?php echo get_option('wpduel_chart_color_one'); ?>">
			<span style="background-color: <?php echo get_option('wpduel_chart_color_one'); ?>"></span>
			<div>
				<h3><?php echo $this->results->contender_one['title']; ?></h3>
				<p><?php echo $this->results->contender_one['percentage']; ?>%</p>
			</div>
		</li>
		<li style="color: <?php echo get_option('wpduel_chart_color_two'); ?>">
			<span style="background-color: <?php echo get_option('wpduel_chart_color_two'); ?>"></span>
			<div>
				<h3><?php echo $this->results->contender_two['title']; ?></h3>
				<p><?php echo $this->results->contender_two['percentage']; ?>%</p>
			</div>
		</li>
	</ul>
	<div id="results" style="height:300px; width:300px;"></div>
</div>

<?php if ( !is_singular('duel') ) : ?>
<button class="wpduel-button" onclick="location.reload()">Next Duel</button>
<?php endif; ?>

<script>
var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();

function plotChart()
{
	var width = jQuery('#results').parent().width() * .75;
	jQuery('#results').width(width).height(width) * .75;

	var plot1 = jQuery.jqplot('results', [[
		['a', <?php echo $this->results->contender_one['percentage']; ?>] , 
		['b',<?php echo $this->results->contender_two['percentage']; ?>]
		]], {
		animate: true,
		seriesDefaults: {
			renderer : jQuery.jqplot.PieRenderer, 
			shadow: false,
			trendline : { 
				show : false 
			}, 
			rendererOptions : { 
				padding: 0, 
				showDataLabels: false,
				highlightMouseOver: false,
				highlightMouseDown: false,
				highlightColor: null,
			}
		},
		legend: {
			show : false
		}
	});

	plotStyles = {
		seriesStyles: {
			seriesColors: ['<?php echo get_option('wpduel_chart_color_one'); ?>', '<?php echo get_option('wpduel_chart_color_two'); ?>'],
		},
		grid: {
			borderWidth: 0,
			shadow: false,
			backgroundColor: 'rgb(255, 255, 255)'
		}
	};

	plot1.themeEngine.newTheme('wpduel', plotStyles);
	plot1.activateTheme('wpduel');
}

jQuery(document).ready(function(){
	plotChart();
});

jQuery(window).resize(function() {
	delay(function(){
		plotChart();
	}, 500);
});
</script>