<?php
/**
* Plugin Name: HMS
* Plugin URI: https://github.com/bkoppe/hms-plugin
* Description: Plugins für HMS
* Version: 1.0
* Author: Benjamin Koppe
* Author URI: https://github.com/bkoppe
* License: free
*/

add_shortcode('hms-tabelle', 'hms_show_ranking' );

function hms_show_ranking($args){
	
	if(empty($args)){
		return "";
	}
	
	$values = shortcode_atts( array(
		'saison' => 'current',
        'team' => '#'
    ), $args );
	
	$response = @file_get_contents('http://localhost:8081/api/v1/tabellen/'.$values['saison'].'/'.$values['team']);
	if($response === FALSE){
		return "Tabelle kann aktuell nicht geladen werden.";
	}
	
	$ranking = json_decode($response, true);
	$ranks = $ranking['ranks'];
	
	$html;
	
	$html .= '<table border=1>';
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= '<th>Rang</th>';
	$html .= '<th>Mannschaft</th>';
	$html .= '<th>Spiele</th>';
	$html .= '<th>S</th>';
	$html .= '<th>U</th>';
	$html .= '<th>N</th>';
	$html .= '<th>Tore</th>';
	$html .= '<th>+/-</th>';
	$html .= '<th>Punkte</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	
	for ($i = 0; $i < sizeof($ranks); $i++) {
		$html .= '<tr>';
		$html .= '<td>'.$ranks[$i]['position']  .'</td>';
		$html .= '<td>'.$ranks[$i]['team']  .'</td>';
		$html .= '<td>'.$ranks[$i]['gamesPlayed']  .'</td>';
		$html .= '<td>'.$ranks[$i]['wins']  .'</td>';
		$html .= '<td>'.$ranks[$i]['draws']  .'</td>';
		$html .= '<td>'.$ranks[$i]['losses']  .'</td>';
		$html .= '<td>'.$ranks[$i]['goals']  .'</td>';
		$html .= '<td>'.$ranks[$i]['goalDifferential']  .'</td>';
		$html .= '<td>'.$ranks[$i]['points']  .'</td>';
		$html .= '</tr>';
	}
	
	$html .= '</table>';
	return $html;
}
?>