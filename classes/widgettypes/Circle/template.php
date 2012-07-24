<div class="numfield" id="wct<?= $id ?>" style="height: 100px;">

	<script>
		(function() {
			widgetData.paper = Raphael("wct<?= $id ?>");
			widgetData.paper.customAttributes.segment = function (x, y, r, a1, a2) {
				var flag = (a2 - a1) > 180,
				    clr = (a2 - a1) / 360;
				    a1 = (a1 % 360) * Math.PI / 180;
				    a2 = (a2 % 360) * Math.PI / 180;

				// ["M", 125, 70], ["l", -70, 8.572244476756641e-15], ["A", 70, 70, 0, 0, 1, 195, 70], [Z]				    
				return {
					path: [["M", x, y], ["l", r * Math.cos(a1), r * Math.sin(a1)], ["A", r, r, 0, +flag, 1, x + r * Math.cos(a2), y + r * Math.sin(a2)], ["z"]],
				};
				// fill: "hsb(" + clr + ", .75, .8)"
			};			

			widgetData.clr = '<?= $color ?>';
			widgetData.paper.circleShadow = widgetData.paper.path();
			widgetData.paper.circleShadow.attr({
				segment: [125, 70, 70, 180, 360],
				stroke: "#fff",
				fill: "#ddd"
			});
			widgetData.paper.circle = widgetData.paper.path();
			widgetData.paper.circle.attr({
				segment: [125, 70, 70, 180, 300], stroke: "#fff",
				fill: widgetData.clr
			});

			widgetData.paper.caption = widgetData.paper.text(125, 85, '100% von irgendwas').attr(
				{ "font-size": 14, "font-family": "verdana", "fill": widgetData.clr}
			);
		})();
	</script>
</div>
