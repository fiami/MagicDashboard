<div class="numfield" id="wct<?= $id ?>" style="height: 100px;">
	<script>
		(function() {
			widgetData.paper = Raphael("wct<?= $id ?>", 250, 250);

			widgetData.rect = widgetData.paper.rect(0, 30, 250, 40, 5);
			widgetData.rect.attr("stroke-width", "0");
			widgetData.rect.attr("fill", "#ddd");

			widgetData.clr = '<?= $color ?>';
			widgetData.rect = widgetData.paper.rect(0, 30, 200, 40, 5);
			widgetData.rect.attr("stroke-width", "0");
			widgetData.rect.attr("fill", widgetData.clr);

			widgetData.paper.caption = widgetData.paper.text(125, 85, 'Irgend ein Text').attr(
				{ "font-size": 14, "font-family": "verdana", "fill": widgetData.clr}
			);

			widgetData.topGraph = new RaphaelQuickChart({
				x: 4,
				y: 4,
				width: 241,
				height: 21,
				xSteps: 10,
				gridClr: "#ddd",
				graphClr: "<?= $color ?>",
				raphael: widgetData.paper
			});			
		})();
	</script>
</div>
