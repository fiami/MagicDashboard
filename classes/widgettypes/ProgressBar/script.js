MagicDashboard.registerUpdate(
	function( divObject, data, widgetData ) {

		widgetData.rect.animate({
			width: 250 * (data.number / 100),
			fill: widgetData.clr
		}, 500, '<>');

		
		var perc = data.number; // (100 / 250 * (250 / 5 * data.number));
		var description = typeof data.description != 'undefined' ? data.description : perc+"%";

		widgetData.paper.caption.remove();
		widgetData.paper.caption = widgetData.paper.text(125, 85, ''+description).attr(
			{ "font-size": 14, "font-family": "verdana", "fill": widgetData.clr}
		);

		widgetData.topGraph.addPoint(perc);
	}
);
