<?

class MagicDashboardRenderer {

	const TYPE_HTML = 'html';
	const TYPE_JS = 'js';

	protected static $theme = 'lightGrey';

	protected $widgets = array();

	public function __construct($widgets) {
		$this->widgets = $widgets;
	}

	public static function staticIncludeTags($staticPath = '.') {
		return '
			<link rel="stylesheet" type="text/css" media="all" href="'.$staticPath.'/static/css/MagicDashboard.css" />
			<script src="'.$staticPath.'/static/js/raphael-min.js"></script>
			<script src="'.$staticPath.'/static/js/jquery-1.7.2.min.js"></script>
			<script src="'.$staticPath.'/static/js/MagicDashboard.js"></script>
			<script src="'.$staticPath.'/static/js/RaphaelQuickChart.js"></script>
		';	
	}
	
	public static function setTheme($theme) {
		static::$theme = $theme;
	}

	public function render( $options ) {

		$rendered = "";

		if( !isset($options["type"]) || $options["type"] === null ) {
			$options["type"] = static::TYPE_HTML;
		}

		switch( $options["type"] ) {
		
			// rendert html output
			case self::TYPE_HTML:

				$rendered.= '<div class="magicdashboard">';
				$rendered.= '<link rel="stylesheet" type="text/css" media="all" href="../themes/'.static::$theme.'/style.css" />';

				foreach( $this->widgets as $id => $widget ) {

					// get rendered widget itself
					$renderedWidget = $this->renderWidgetForClass(
						get_parent_class($widget),
						$id,
						$widget->getViewData(),
						$widget->getOptions()
					);

					// render container
					$rendered.= $this->renderContainerForWidget(
						$renderedWidget,
						$id,
						$widget->getCaption()
					);
					
					$rendered.= "<script>$(document).ready(function() {";
					$rendered.= "MagicDashboard.update('".$id."', jQuery.parseJSON('".json_encode($widget->getViewData())."'));";
					$rendered.= "});</script>";
				}

				// if not configured in another way, start automatic updates
				if( !isset($options['deactivateAutomaticUpdates']) || $options['deactivateAutomaticUpdates'] !== true ) {
					$rendered.= '
						<script>$(document).ready(function() {
							MagicDashboard.updateViaInterval();
						});</script>
					';
				}
				$rendered.= '</div>';
				break;

			case self::TYPE_JS:
				$data = array();
				foreach( $this->widgets as $id => $widget ) {
					$data[$id] = $widget->getViewData();
				}		
				$rendered = json_encode( $data );
				break;
		}

		return $rendered;
	}
	
	/**
	 *
	 */
	private function renderWidgetForClass($parentClass, $id, $data, $options) {

		// extract all vars and remove original
		extract($data);
		unset($data);

		// get script
		ob_start();
		$jscontent = "<script>";
		$jscontent.= "MagicDashboard.currentWidget='".$id."';";
		$jscontent.= "MagicDashboard.widgetSettings['".$id."'] = jQuery.parseJSON('".json_encode($options)."');";
		$jscontent.= file_get_contents(__DIR__."/widgettypes/".$parentClass."/script.js");
		$jscontent.= "</script>";
		ob_end_clean();
		
		// render template
		ob_start();
		$color = MagicDashboard::getRandomColor();
		require(__DIR__."/widgettypes/".$parentClass."/template.php");
		$content.= ob_get_contents();
		ob_end_clean();
		
		// return rendered widget
		return $jscontent.$content;
	}

	/**
	 *
	 */
	private function renderContainerForWidget($widget, $id, $caption) {
		ob_start();
		$container = "<script>";
		$container.= " var widgetData = new Object();";
		$container.= "</script>";
		require(__DIR__."/../themes/".static::$theme."/container.php");
		$container.= ob_get_contents();
		$container.= "<script>";
		$container.= "MagicDashboard.setObjectNamespaces('".$id."', widgetData);";
		$container.= "</script>";
		ob_end_clean();
		return $container;
	}
}

?>
