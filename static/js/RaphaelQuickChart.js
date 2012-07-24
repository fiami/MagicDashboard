/**
 *
 */
var RaphaelQuickChart = function(settings) {

	this.currentData = new Array();
	this.currentElements = widgetData.paper.set();
	this.settings = $.extend({
		x: 4,
		y: 4,
		width: 241,
		height: 21,
		xSteps: 10,
		gridClr: "#ddd",
		graphClr: "#eee",
		raphael: null
	}, settings);

	this.addPoint = function(y) {
		var oldData = this.currentData;
		oldData.unshift(y);
		oldData = oldData.splice(0,this.settings.xSteps);

		this.currentElements.remove();

		var stepSize = this.settings.width / (this.settings.xSteps-1);
		var lines = new Array();
		for (var i = 0; i < this.settings.xSteps; ++i) {
			var currentPosition = this.settings.xSteps - i - 1;
			var currentX = this.settings.x + (currentPosition * stepSize);
			if( typeof oldData[i] != "undefined" ) {
		
				var currentY = (this.settings.height - this.settings.y) / 100 * oldData[i];
				currentY = this.settings.y + (this.settings.height - currentY);
				lines.push([( lines.length == 0 ? "M" : "L" ), currentX, currentY]);
				var newCircle = this.settings.raphael.circle(currentX, currentY, 2);
				newCircle.attr({
					"fill": this.settings.graphClr,
					"stroke-width": 0,
					"fill-opacity": 0.5
				});
				this.currentElements.push(newCircle);
			}
		}

		var line = this.settings.raphael.path();
		line.attr({
			path: lines,
			stroke: this.settings.graphClr,
			"stroke-width": 1,
			"stroke-opacity": 0.5
		});
		this.currentElements.push(line);
		this.currentData = oldData;
	}
}
