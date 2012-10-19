<?

// require autoloader
require("../classes/MagicDashboardAutoloader.php");

// get content type
$type = !isset($_GET["type"]) ? "html" : $_GET["type"];

// widget configuration
$widgetsConfig = array(
	array(
		"name" => "RandomNumberProgress",
		"update" => 1,
		"caption" => "Just a random number"
	),
	array(
		"name" => "HttpPing",
		"update" => 2,
		"caption" => "Ping auf google / 1ms = 10%"
	)
);

// print header header
if( $type == "html" ) {
	echo "<html>
		<head>
			<meta charset='utf-8'/>
			<title>Magic Dashboard</title>
			".MagicDashboardRenderer::staticIncludeTags('..')."
		</head>
		<body>
	";
}

// load and render actual dashboard
$dashboard = new MagicDashboard();
$dashboard->load($widgetsConfig);
echo $dashboard->render();

// print html footer
if( $type == "html" ) echo "</body></html>";

?>

