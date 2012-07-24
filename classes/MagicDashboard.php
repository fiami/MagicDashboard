<?

/**
 *
 */
class MagicDashboard {

	/**
	 *
	 */
	protected $widgets = array();

	/**
	 * TODO: change caching to own engine, so that we can use APC instead e.g.
	 */
	protected $options = array(
		"contentTypeFromGET" => "type", // $_GET var name for type
		"widgetsFromGET" => "widgets", // $_GET var name for widgets to update
		"deactivateAutomaticUpdates" => false, // true or false
		"activateCaching" => null // directory to save
	);

	/**
	 * options
	 *  - contentTypeFromGET ... default type
	 *  - widgetsFromGET ... default widgets
	 *  - deactivateAutomaticUpdates ... default false (so automatic updates are activated)
	 *  - activateCaching ... default null (so no cache at all)
	 */
	public function __construct($options = array()) {
		foreach( $options as $key => $value ) {
			$this->options[$key] = $value;
		}
	}

	/**
	 *
	 */
	public function load($widgets, $widgetsToLoad = null) {

		// get widgets to show
		if( $widgetsToLoad === null && isset($_GET[$this->options["widgetsFromGET"]]) ) {
			$widgetsToLoad = explode(",", $_GET[$this->options["widgetsFromGET"]]);
		}

		$i=0;
		foreach( $widgets as $raw ) {
			$options = $raw;
			unset($options["name"]);
			if( $widgetsToLoad === null || in_array("widget".$i, $widgetsToLoad) ) {
				$this->widgets["widget".$i] = new $raw["name"]($options);
			}
			$i++;
		}
	}

	/**
	 *
	 */
	protected function calculate() {
		foreach( $this->widgets as $w ) {
			$w->collectForView();
		}
	}
	
	/**
	 *
	 */
	protected function getWidgets() {
		return $this->widgets;
	}

	/**
	 * options contentype kann überschrieben werden / auch beim renderer dokumentieren
	 */
	public function render($options = array()) {
		
		// get type
		$type = null;
		if( isset($options["type"]) ) {
			$type = $options["type"];
		} elseif( isset($_GET[$this->options["contentTypeFromGET"]]) ) {
			$type = $_GET[$this->options["contentTypeFromGET"]];
		}

		// is cache activated?
		$cacheFile = null;
		$rendered = null;
		if( $this->options["activateCaching"] ) {
			$cacheFile = $this->options["activateCaching"].'/md_'.md5(json_encode($this->widgets))."_".($type ? $type : 'default');
			if( file_exists($cacheFile) ) $rendered = file_get_contents($cacheFile);			
		}

		// only calculate if we did not get content from cache
		if( !$rendered ) {
			// calculate widget results and get vars for view
			$this->calculate();

			// load renderer and pass options
			$renderOptions = array('type' => $type);
			if( isset($this->options['deactivateAutomaticUpdates']) ) {
				$renderOptions['deactivateAutomaticUpdates'] = $this->options['deactivateAutomaticUpdates'];
			}
			$renderer = new MagicDashboardRenderer($this->getWidgets());
			$rendered = $renderer->render( $renderOptions );
			
			// save in cache
			if( $this->options["activateCaching"] && $cacheFile ) {
				$handle = fopen($cacheFile, "a");
				fwrite($handle, $rendered);
				fclose($handle);
			}
		}
		return $rendered;
	}

	/**
	 *
	 */
	public static function getRandomColor() {
		$clr = array(
			'#E8DE2F', // yellow
			'#33CC7B', // green
			'#CC3333', // red
			'#3339CC', // blue
			'#CC33CC', // purple
			'#F1A933'  // orange
		);
		return $clr[rand(0, count($clr)-1)];
	}
}

?>
