<?php
if(gameState==board){
	if(questionsLessThan2000Exist){
		$board = $signleBoard;
	}else{
		$board = $doubleBoard;
	}
	$html = $board + $scores;
}elseif(gameState==question){
	lookupQuestion();
	$html = $question + $scores;
}elseif(gameState==finalWager){

}elseif(){
	
}
?>