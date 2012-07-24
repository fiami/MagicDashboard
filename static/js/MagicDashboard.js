MagicDashboard = function() {};
MagicDashboard.currentWidget = null;
MagicDashboard.numberUpdates = 0;
MagicDashboard.widgetSettings = new Object();
MagicDashboard.registeredCallbacks = new Object();
MagicDashboard.registeredCallbacks["update"] = new Object();

MagicDashboard.objectNamespaces = new Object();

MagicDashboard.setObjectNamespaces = function(widgetid, data) {
	MagicDashboard.objectNamespaces[widgetid] = data;
}

MagicDashboard.getObjectNamespaces = function(widgetid) {
	return MagicDashboard.objectNamespaces[widgetid];
}

MagicDashboard.registerUpdate = function(callback) {
	this.registeredCallbacks["update"][this.currentWidget] = callback;
}

MagicDashboard.update = function(id, data) {
	$('#'+id).addClass("updatedwidget");
	MagicDashboard.registeredCallbacks["update"][id]( $('#'+id), data, MagicDashboard.getObjectNamespaces(id) );
	setTimeout('$("#'+id+'").removeClass("updatedwidget");', 1000);
}

MagicDashboard.updateViaInterval = function() {

	var widgetsToUpdate = new Array();

	for( widget in MagicDashboard.widgetSettings ) {
		if( MagicDashboard.numberUpdates % MagicDashboard.widgetSettings[widget].update == 0
		    && MagicDashboard.numberUpdates > 0) {
			widgetsToUpdate.push(widget);
		}
	}

	if( widgetsToUpdate.length > 0 ) {
		$.ajax({
			url: "?type=js&widgets="+widgetsToUpdate.join(","),
			context: document.body,
			dataType: "json",
			success: function( data ) {
				for( widget in data ) {
					MagicDashboard.update( widget, data[widget] );
				}
				setTimeout("MagicDashboard.updateViaInterval()", 5000);
			}
		});
	} else {
		setTimeout("MagicDashboard.updateViaInterval()", 5000);
	}
	MagicDashboard.numberUpdates++;
}
