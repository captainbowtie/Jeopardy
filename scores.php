<?php
$scoreHTML = "<table><tr>";
for(numberOfPlayers){
	$scoreeHTML .= "<td>$userName</td>";
}
$scoreHTML .= "</tr><tr>";
for(numberOfPlayers){
	$scoreeHTML .= "<td>$userScore</td>";
}
$scoreHTML .= "</tr></table>";
echo $scoreHTML;
?>