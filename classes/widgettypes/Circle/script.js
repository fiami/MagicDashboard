MagicDashboard.registerUpdate(
	function( divObject, data, widgetData ) {

		var perc = data.number;

		widgetData.paper.circle.animate({segment: [127, 70, 68, 180, 180 + (perc/100*180)], stroke: widgetData.clr, fill: widgetData.clr}, 500, "<>");		
		widgetData.paper.caption.remove();
		widgetData.paper.caption = widgetData.paper.text(125, 85, perc + '% von irgendwas').attr(
			{ "font-size": 14, "font-family": "verdana", "fill": widgetData.clr}
		);
	}
);
