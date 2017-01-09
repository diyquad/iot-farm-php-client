<?php
	// Rapporte toutes les erreurs à part les E_NOTICE
// C'est la configuration par défaut de php.ini
error_reporting(E_ALL & ~E_NOTICE);
//Les variables PHP utilisées partout
$nodejs = "http://89.2.170.137:5001";
$camera = "http://89.2.170.137:8080/?action=stream";

/*$host = 'mysql-robotperso.alwaysdata.net';
$mysql_user = '130280_iotfarm';
$mysql_pass = 'test12345';
$mysql_db = 'robotperso_iotfarm';
*/
$host = 'vps356572.ovh.net';
$mysql_user = 'elie';
$mysql_pass = 'clic2clic55';
$mysql_db = 'robotperso';


// on se connecte à MySQL
//$db = mysql_connect($host, $mysql_user, $mysql_pass); 
// on sélectionne la base
//mysql_select_db($mysql_db,$db); 



/*
	Envoi des datas au nodeJS distant
	$type string, $data array	
*/
function sendData($type,$data) {
    $data_string = json_encode($data);                                                                                   

    $ch = curl_init('http://localhost:3000/push');                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                 
    );
    curl_exec($ch);
}

/*
	Recupe les datas moisture (les 300 dernieres valeurs
*/
function getDataMoisture() {
	$data = array();
	$query = "select count(*) as count from sensors where type='sensors'";
	$req = mysql_query($query);
	while($res = mysql_fetch_array($req)) {
		$count = $res['count'];
	}

	$debut = ($count - 300);
	$query = "select * from sensors where type='sensors' order by date ASC limit ".$debut.", 300";
	$mquery = mysql_query($query) or die('Erreur mysql '.mysql_error().' '.$query);
	while($res = mysql_fetch_array($mquery)) {
		$contenu = json_decode ($res['data']);
		$tab = array($contenu->{'date'},$contenu->{'moisture'});
		$data[] .= $tab;
	}
	return $data;
}

function AjouterInfos($data) {
	
	$data['date'] = date("Y-m-d H:i:s");
	$data['titre'] = $_REQUEST['titre'];
	$data['texte'] = $_REQUEST['text'];
	$data['plant'] = 1;
	
	$url = 'http://robotperso.eu/api/api.php/infos';

	$data_string = json_encode($data);
	$ch=curl_init($url);
	curl_setopt_array($ch, array(
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => $data_string,
	    CURLOPT_HEADER => false,
	    CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string))
	));
	
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
	

					
					
	



?>