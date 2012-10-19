<?

// require autoloader
require("../classes/MagicDashboardAutoloader.php");

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
echo "<html>
	<head>
		<meta charset='utf-8'/>
		<title>Magic Dashboard</title>
		".MagicDashboardRenderer::staticIncludeTags('..')."
	</head>
	<body>";

// load faster version without automatic updates
// and with caches in /tml directory
$dashboard = new MagicDashboard(array(
	"deactivateAutomaticUpdates" => true,
	"activateCaching" => "/tmp"
));
$dashboard->load($widgetsConfig);
echo $dashboard->render();

echo "</body></html>";

?>

