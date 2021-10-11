<?php
// Github Domifry
$Datenbank = "INSERT";
$Passwort = "INSERT";
//$edition = "winter";
$edition = "sommer";
$sonne = 0;
$defizit = 3;
$feuchtschatten = 0;
$feuchtsonne = 0;

/* kommentiere das ein wenn du Wetterdaten aus dem Netz haben willst Schreibe dazu bei ZIP deine PLZ und bei APPID die API ID rein.
$url = "http://api.openweathermap.org/data/2.5/weather?zip=90461,de&appid=ID";
$response=WeatherUrl($url);

$data = json_decode($response);
$temp = $data->main->temp-273.15 ." Grad";
$minimum_temp = $data->main->temp_min-273.15 . " Grad";
$maximum_temp = $data->main->temp_max-273.15 . " Grad";
$feels_like = $data->main->feels_like-273.15 . " Grad";
$pressure = $data->main->pressure;
$humidity = $data->main->humidity . " %";
$wind = $data->wind->speed . " km/h";
$weather = $data->weather[0]->description;
$humidity1 = $data->main->humidity;
$wind1 = $data->wind->speed;
$temp1 = $data->main->temp-273.15;
$minimum_temp1 = $data->main->temp_min-273.15;
$maximum_temp1 = $data->main->temp_max-273.15;
$wind1 = $data->wind->speed;

function WeatherUrl($url){
		$cn = curl_init();
		curl_setopt($cn, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cn, CURLOPT_URL, $url);    // get the contents using url
		$weatherdata = curl_exec($cn); // execute the curl request
		curl_close($cn); //close the cURL
		return $weatherdata;
}

function wetter($var){

global $temp,$minimum_temp,$maximum_temp,$feels_like,$humidity,$wind,$weather,$humidity1,$wind1,$temp1,$minimum_temp1,$maximum_temp1,$wind1;

switch ($var) {
  case ("wind"):
    echo $wind;
    break;

    case ("maxtemp"):
      echo $maximum_temp;
      break;

    case ("mintemp"):
      echo $minimum_temp;
      break;

    case ("feel"):
      echo $feels_like;
      break;

    case ("wetter"):
      echo $weather;
      break;

    case ("wind"):
      echo $wind;
      break;

    case ("humidity"):
      echo $humidity;
      break;

    case ("maxtemp1"):
      echo $maximum_temp1;
      break;

    case ("mintemp1"):
      echo $minimum_temp1;
      break;

    case ("humidity1"):
      echo $humidity1;
      break;

      case ("wind1"):
        echo $wind1;
        break;

      case ("temp1"):
        echo $temp1;
        break;
      }
return;
}
*/

function sonne() {
global $sonne;
global $temp1;
global $feuchtsonne;

global $Datenbank, $Passwort, $defizit;
	// Create connection
$con=mysqli_connect("localhost",$Datenbank,$Passwort,$Datenbank);
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// Suche die Anzahl der Tabellen
$result = mysqli_query($con, "SELECT COUNT(ID) as anzahl FROM `Sonne`");
$data=mysqli_fetch_assoc($result);
$total = $data['anzahl'];
//suche nun den letzten Wert
$result = mysqli_query($con, 'SELECT * FROM `Sonne` WHERE ID='.$total);
$row = $result->fetch_array();
$json = $row['Sonne'];
$json1 = json_decode($json,true);
$sonne = $json1["temperature_C"];
$feuchtsonne = $json1["humidity"];

if ($sonne > 25) {
echo("<b>".$sonne." Grad </b> <br> &nbsp; &nbsp;Kurze Hosen sind angesagt!");
}
if ($sonne <= 25 && $sonne >= 19) {
echo("<b>".$sonne." Grad </b> <br> &nbsp; &nbsp;Es ist Zeit für chillige Sommersachen!");
}
if ($sonne < 19 && $sonne > 14) {
echo("<b>".$sonne." Grad </b> <br> &nbsp; &nbsp;Es Zeit für eine dünne Jacke!");
}
if ($sonne <= 14 && $sonne > 11) {
echo("<b>".$sonne." Grad </b> <br> &nbsp; &nbsp;Es wird Zeit für einen Pulli!");
}
if ($sonne <= 11 && $sonne > 8) {
echo("<b>".$sonne." Grad </b> <br> &nbsp; &nbsp; Eine Dicke Jacke ist wichtig!");
}
if ($sonne <= 8 && $sonne > 4) {
echo("<b>".$sonne." Grad </b> <br> &nbsp; &nbsp;Es Zeit die Thermosachen!");
}
if ($sonne <= 4) {
echo("<b>".$sonne." Grad </b> <br> &nbsp; &nbsp;Pack dich warm ein!");
}

return;
}

function schatten() {
global $sonne;
global $minimum_temp1;
global $feuchtschatten;
global $Datenbank, $Passwort, $defizit;
	// Create connection
$con=mysqli_connect("localhost",$Datenbank,$Passwort,$Datenbank);
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// Suche die Anzahl der Tabellen
$result = mysqli_query($con, "SELECT COUNT(ID) as anzahl FROM `Schatten`");
$data=mysqli_fetch_assoc($result);
$total = $data['anzahl'];
//suche nun den letzten Wert
$result = mysqli_query($con, 'SELECT * FROM `Schatten` WHERE ID='.$total);
$row = $result->fetch_array();
$json = $row['Schatten'];
$json1 = json_decode($json,true);
$schatten = $json1["temperature_C"];
$feuchtschatten = $json1["humidity"];
$unterschied = $sonne - $schatten;

if ($unterschied < 5) {
  echo("<b>".$schatten." Grad </b> <br> &nbsp; &nbsp;Es ist recht ähnlich!");
} else {
  echo("<b>".$schatten." Grad </b> <br> &nbsp; &nbsp;Die Sonne scheint ganz gut!");
}
return;
}

function wind() {
global $sonne, $wind1,$Datenbank,$Passwort;
$con=mysqli_connect("localhost",$Datenbank,$Passwort,$Datenbank);
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// Suche die Anzahl der Tabellen
$result = mysqli_query($con, "SELECT COUNT(ID) as anzahl FROM `Wind`");
$data=mysqli_fetch_assoc($result);
$total = $data['anzahl'];
//suche nun den letzten Wert
$result = mysqli_query($con, 'SELECT * FROM `Wind` WHERE ID='.$total);
$row = $result->fetch_array();
$json = $row['Wind'];
$json1 = json_decode($json,true);
$wind = $json1["wind_avg_km_h"];
$gefuehlt = 13.12+(0.6215*$sonne)-(11.37*pow($wind,0.16))+(0.3965*$sonne*pow($wind,0.16));
$gefuehlt = round($gefuehlt,1);

if ($wind > 28) {
echo("<b>".$wind." km/h </b> <br> &nbsp; &nbsp;Steifer Wind!<br>&nbsp; &nbsp;Gefühlt: ".$gefuehlt." Grad!");
}
if ($wind <= 28 && $wind >= 22) {
echo("<b>".$wind." km/h </b> <br> &nbsp; &nbsp;Starker Wind!<br>&nbsp; &nbsp;Gefühlt: ".$gefuehlt." Grad!");
}
if ($wind < 21 && $wind > 16) {
echo("<b>".$wind." km/h </b> <br> &nbsp; &nbsp;Frischer Wind!<br>&nbsp; &nbsp;Gefühlt: ".$gefuehlt." Grad!");
}
if ($wind <= 16 && $wind > 11) {
echo("<b>".$wind." km/h </b> <br> &nbsp; &nbsp;Schwacher Wind!<br>&nbsp; &nbsp;Gefühlt: ".$gefuehlt." Grad!");
}
if ($wind <= 11 && $wind > 5) {
echo("<b>".$wind." km/h </b> <br> &nbsp; &nbsp;Leichter Wind!<br>&nbsp; &nbsp;Gefühlt: ".$gefuehlt." Grad!");
}
if ($wind <= 5) {
echo("<b>".$wind." km/h </b> <br> &nbsp; &nbsp;Kaum/kein Wind!<br>&nbsp; &nbsp;Gefühlt: ".$gefuehlt." Grad!");
}

return;
}
function luftfeuchtigkeit() {
global $sonne, $feuchtsonne, $feuchtschatten;
$sonne1 = ceil($sonne);
$luftfeuchtigkeit = $feuchtsonne;
//$gefuehlt1 = -8.785 + (1.611*$sonne) + (2.339*$luftfeuchtigkeit) - (0.146*$sonne*$luftfeuchtigkeit) - (0.0123 * pow($sonne,2)) - (0.01642 * pow($luftfeuchtigkeit,2)) + (0.002211 *pow($sonne,2)*$feuchtigkeit) + (0.000725*$sonne*pow($luftfeuchtigkeit,2)) - (0.000003582*pow($sonne,2)*pow($luftfeuchtigkeit,2));
$check = false;
if ($sonne < 16) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp; Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp; &nbsp;Es ist ok!");
$check = true;
}
if ($sonne1 > 37) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp; Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp; &nbsp;Es ist ok!");
$check = true;
}

if ($sonne1 == 16 && $luftfeuchtigkeit >= 99) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp; Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp; &nbsp;Es ist schwül! <br> &nbsp; &nbsp; &nbsp;Gefühlt: 25 Grad!");
$check = true;
}

if ($sonne1 == 17 && $luftfeuchtigkeit >= 93) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp; Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 26 Grad!");
$check = true;
}

if ($sonne1 == 18 && $luftfeuchtigkeit >= 88) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp; &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 27 Grad!");
$check = true;
}

if ($sonne1 == 19 && $luftfeuchtigkeit >= 83) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp; &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 28 Grad!");
$check = true;
}

if ($sonne1 == 20 && $luftfeuchtigkeit >= 78) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp; &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 29 Grad!");
$check = true;
}

if ($sonne1 == 21 && $luftfeuchtigkeit >= 74) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp; &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 30 Grad!");
$check = true;
}

if ($sonne1 == 22 && $luftfeuchtigkeit >= 70) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 31 Grad!");
$check = true;
}

if ($sonne1 == 23 && $luftfeuchtigkeit >= 66) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp; Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 32 Grad!");
$check = true;
}

if ($sonne1 == 24 && $luftfeuchtigkeit >= 62) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 33 Grad!");
$check = true;
}

if ($sonne1 == 25 && $luftfeuchtigkeit >= 59) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 34 Grad!");
$check = true;
}

if ($sonne1 == 26 && $luftfeuchtigkeit >= 56) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 35 Grad!");
$check = true;
}

if ($sonne1 == 27 && $luftfeuchtigkeit >= 53) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 36 Grad!");
$check = true;
}

if ($sonne1 == 28 && $luftfeuchtigkeit >= 50) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 37 Grad!");
$check = true;
}

if ($sonne1 == 29 && $luftfeuchtigkeit >= 47) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): ".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 38 Grad!");
$check = true;
}

if ($sonne1 == 30 && $luftfeuchtigkeit >= 45) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 39 Grad!");
$check = true;
}

if ($sonne1 == 31 && $luftfeuchtigkeit >= 43) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp; Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 40 Grad!");
$check = true;
}

if ($sonne1 == 32 && $luftfeuchtigkeit >= 40) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp; &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 41 Grad!");
$check = true;
}
if ($sonne1 == 33 && $luftfeuchtigkeit >= 38) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp; Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 42 Grad!");
$check = true;
}
if ($sonne1 == 34 && $luftfeuchtigkeit >= 36) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 43 Grad!");
$check = true;
}
if ($sonne1 == 35 && $luftfeuchtigkeit >= 35) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 44 Grad!");
$check = true;
}
if ($sonne1 == 36 && $luftfeuchtigkeit >= 33) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp; Feuchtigkeit (Schatten): ".$feuchtschatten."%</b> <br> &nbsp; &nbsp; &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 45 Grad!");
$check = true;
}
if ($sonne1 == 37 && $luftfeuchtigkeit >= 31) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist schwül!<br> &nbsp; &nbsp; &nbsp;Gefühlt: 46 Grad!");
$check = true;
}

if ($check == false) {
echo("<b>".$luftfeuchtigkeit."% </b> <br> &nbsp; &nbsp;  Feuchtigkeit (Schatten): <b>".$feuchtschatten."%</b> <br> &nbsp;  &nbsp;Es ist ok!");
}
return;
}

function werteschatten() {
	global $Datenbank, $Passwort, $defizit;
		// Create connection
	$con=mysqli_connect("localhost",$Datenbank,$Passwort,$Datenbank);

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// This SQL statement selects ALL from the table 'Locations'
$sql = "SELECT * FROM `Schatten` ORDER BY `ID` DESC LIMIT 0 , 20";

// Check if there are results
$counter = 1;
if ($result = mysqli_query($con, $sql))
{
	// Loop through each row in the result set
		while($row = $result->fetch_array()) {
		// Add each row into our results array
		$temp = $row['Zeit'];
		$datum1 = substr($temp,0,11);
		$datum = substr($datum1,8,-1).".".substr($datum1,5,-4).".".substr($datum1,0,-7);
		$zeit = substr($temp,10);
		$json = $row['Schatten'];
	  $shadow = json_decode($json,true);
	  $Schattentemp = $shadow["temperature_C"];
		echo('    <tr>
			<th scope="row">'.$counter.'</th>
			<td>'.$Schattentemp.'</td>
			<td>'.$datum.'</td>
			<td>'.$zeit.'</td>
		</tr>');
		$counter++;
	}
} return;
	}

	function wertesonne() {
		global $Datenbank, $Passwort, $defizit;
			// Create connection
		$con=mysqli_connect("localhost",$Datenbank,$Passwort,$Datenbank);

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// This SQL statement selects ALL from the table 'Locations'
	$sql = "SELECT * FROM `Sonne` ORDER BY `ID` DESC LIMIT 0 , 20";

	// Check if there are results
	$counter = 1;
	if ($result = mysqli_query($con, $sql))
	{
		// Loop through each row in the result set
			while($row = $result->fetch_array()) {
			// Add each row into our results array
			$temp = $row['Zeit'];
			$datum1 = substr($temp,0,11);
			$datum = substr($datum1,8,-1).".".substr($datum1,5,-4).".".substr($datum1,0,-7);
			$zeit = substr($temp,10);
			$json = $row['Sonne'];
		  $sun = json_decode($json,true);
		  $Sonnentemp = $sun["temperature_C"];
			echo('    <tr>
				<th scope="row">'.$counter.'</th>
				<td>'.$Sonnentemp.'</td>
				<td>'.$datum.'</td>
				<td>'.$zeit.'</td>
			</tr>');
			$counter++;
		}
	} return;
		}

		function wertewind() {
			global $Datenbank, $Passwort, $defizit;
				// Create connection
			$con=mysqli_connect("localhost",$Datenbank,$Passwort,$Datenbank);

		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		// This SQL statement selects ALL from the table 'Locations'
		$sql = "SELECT * FROM `Wind` ORDER BY `ID` DESC LIMIT 0 , 20";

		// Check if there are results
		$counter = 1;
		if ($result = mysqli_query($con, $sql))
		{
			// Loop through each row in the result set
				while($row = $result->fetch_array()) {
				// Add each row into our results array
				$temp = $row['Zeit'];
				$datum1 = substr($temp,0,11);
				$datum = substr($datum1,8,-1).".".substr($datum1,5,-4).".".substr($datum1,0,-7);
				$zeit = substr($temp,10);
				$json = $row['Wind'];
				$windy = json_decode($json,true);
				$wind = $windy["wind_avg_km_h"];
				//$sun = json_decode($json,true);
				//$Sonnentemp = $sun["temperature_C"];
				echo('    <tr>
					<th scope="row">'.$counter.'</th>
					<td>'.$wind.'</td>
					<td>'.$datum.'</td>
					<td>'.$zeit.'</td>
				</tr>');
				$counter++;
			}
		} return;
			}
			function werteregen() {
				global $Datenbank, $Passwort, $defizit;
					// Create connection
				$con=mysqli_connect("localhost",$Datenbank,$Passwort,$Datenbank);

			// Check connection
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			// This SQL statement selects ALL from the table 'Locations'
			$sql = "SELECT * FROM `Regen` ORDER BY `ID` DESC LIMIT 0 , 20";

			// Check if there are results
			$counter = 1;
			if ($result = mysqli_query($con, $sql))
			{
				// Loop through each row in the result set
					while($row = $result->fetch_array()) {
					// Add each row into our results array
					$temp = $row['Zeit'];
					$datum1 = substr($temp,0,11);
					$datum = substr($datum1,8,-1).".".substr($datum1,5,-4).".".substr($datum1,0,-7);
					$zeit = substr($temp,10);
					$json = $row['Regen'];
				  $shadow = json_decode($json,true);
				  $rain = $shadow["rain_mm"];
					echo('    <tr>
						<th scope="row">'.$counter.'</th>
						<td>'.$rain.'</td>
						<td>'.$datum.'</td>
						<td>'.$zeit.'</td>
					</tr>');
					$counter++;
				}
			} return;
				}?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/main.css">
    <title>Wetterstation </title>
  </head>
    <body>
<nav class=" navbar navbar-expand-md navbar-dark bg-dark mb-4">
      <a class="navbar-brand" href="#">Wetterstation <?php if ($edition == "sommer") {echo("(Sommer Edition)");} else {echo("(Winter Edition)");}?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      </div>
    </nav>
    <main role="main" class="container">
          <div class="jumbotron">
            <h1>Wetterstation</h1>
            <p class="lead">
              <br>
              <table>
                <tr> <td> <img src="/img/sonne.png" width="50px"> </td><td><br>&nbsp; &nbsp;Temperatur (Sonne): <?php sonne(); ?>&nbsp; &nbsp; &nbsp;</td><td> &nbsp; &nbsp;<img src="/img/schatten.png" width="50px"></td><td><br>&nbsp; &nbsp;Temperatur (Schatten): <?php schatten(); ?> &nbsp; &nbsp; &nbsp;</td></tr><tr><td><br><br></td><td></td></tr><tr><td> &nbsp; &nbsp;<img src="/img/luftfeuchtigkeit.png" width="40px"> </td><td><br>&nbsp; &nbsp; Luftfeuchtigkeit: <?php luftfeuchtigkeit(); ?></td><td> &nbsp; &nbsp;<img src="/img/wind.png" width="70px"> </td><td><br>&nbsp; &nbsp; Wind: <?php wind(); ?></td></p> </tr>

              </table>

            </p>
          </div>
        </main>
/*
        <main role="main" class="container">
              <div class="jumbotron">
                <h1>Wetterbericht</h1>
                <p class="lead">
                  <br>
                  <table>
                    <tr> <td> <img src="/luft/img/sonne.png" width="50px"> </td><td><br>&nbsp; &nbsp;Maximale Temperatur: <b><?php wetter("maxtemp"); ?></b>&nbsp; &nbsp; &nbsp;</td><td> &nbsp; &nbsp;<img src="/img/schatten.png" width="50px"></td><td><br>&nbsp; &nbsp;Minimale Temperatur: <b><?php wetter("mintemp"); ?></b> &nbsp; &nbsp; &nbsp;</td></tr><tr><td><br><br></td><td></td></tr><tr><td> &nbsp; &nbsp;<img src="/img/luftfeuchtigkeit.png" width="40px"> </td><td><br>&nbsp; &nbsp; Luftfeuchtigkeit: <b><?php wetter("humidity"); ?></b></td><td> &nbsp; &nbsp;<img src="/luft/img/wind.png" width="70px"> </td><td><br>&nbsp; &nbsp; Wind: <b><?php wetter("wind"); ?></b></td></p> </tr>
                  </table> <br><br>
<p class="lead">Die Temperatur ist gefühlt <b><?php wetter("feel");?></b> und das Wetter ist: <b> <?php wetter("wetter");?></b></p>
              </div>

            </main>
     */
<h1>Alle Schatten Werte</h1>
	<p class="lead">Hier finden sich die letzten Schatten Werte</p>
<table class="table table-hover">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Temperatur</th>
<th scope="col">Datum</th>
<th scope="col">Zeit</th>
</tr>
</thead>
<tbody>
<?php echo(werteschatten());?>
</tbody>
</table>
</div> </main>
<main role="main" class="container">
<div>
<h1>Alle Sonnen Werte</h1>
	<p class="lead">Hier finden sich die letzten Sonnen Werte</p>
<table class="table table-hover">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Temperatur</th>
<th scope="col">Datum</th>
<th scope="col">Zeit</th>
</tr>
</thead>
<tbody>
<?php echo(wertesonne());?>
</tbody>
</table>
</div> </main>
<main role="main" class="container">
<div>
<h1>Alle Wind Werte</h1>
	<p class="lead">Hier finden sich die letzten Wind Werte</p>
<table class="table table-hover">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Wind</th>
<th scope="col">Datum</th>
<th scope="col">Zeit</th>
</tr>
</thead>
<tbody>
<?php echo(wertewind());?>
</tbody>
</table>
</div> </main>
<main role="main" class="container">
<div>
<h1>Alle Regen Werte</h1>
	<p class="lead">Hier finden sich die letzten Regen Werte</p>
<table class="table table-hover">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Regen</th>
<th scope="col">Datum</th>
<th scope="col">Zeit</th>
</tr>
</thead>
<tbody>
<?php echo(werteregen());?>
</tbody>
</table>
</div> </main>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
