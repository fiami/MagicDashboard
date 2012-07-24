<?

abstract class MagicDashboardWidget {

	protected $options = array();

	private $viewData = array();

	public function __construct( $options ) {
		$this->options = $options;
	}

	public function getCaption() {
		return $this->options["caption"];
	}

	public function getOptions() {
		return $this->options;
	}

	public function collectForView() {
		$this->viewData = $this->calculate();
	}

	public function getViewData() {
		return $this->viewData;
	}

	public abstract function calculate();

}

?>
