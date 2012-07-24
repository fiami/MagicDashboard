<?

class HttpPing extends ProgressBar {


	public function calculate() {
	
		ob_start();
		system("ping -c 1 www.google.de");
		$pingres = ob_get_contents();
		ob_end_clean();

		$matches = array();
		preg_match( '/(time=(([0-9\.])+ ms))/', $pingres, $matches);
		
		$time = isset($matches[2]) ? floatval($matches[2]) : 0;

		$pingPerc = $time / 10;
		return array(
			"number" => $pingPerc
		);
	}



}

?>
