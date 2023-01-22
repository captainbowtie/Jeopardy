<?php
if(thereAreSingleQuestions){
	categories = single categories;
	$v = 200;
}else{
	categories = double categories;
	$v = 400;
}

?>
<table id="board">
	<tr id='categories'>
		<td class='category'><?php echo $c0; ?></td>
		<td class='category'><?php echo $c1; ?></td>
		<td class='category'><?php echo $c2; ?></td>
		<td class='category'><?php echo $c3; ?></td>
		<td class='category'><?php echo $c4; ?></td>
		<td class='category'><?php echo $c5; ?></td>
	</tr>
	<tr id='row1'>
		<td id='c0-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c1-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c2-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c3-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c4-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c5-0' class='question'>$<?php echo $v * 1; ?></td>
	</tr>
	<tr id='row2'>
		<td id='c0-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c1-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c2-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c3-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c4-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c5-1' class='question'>$<?php echo $v * 2; ?></td>
	</tr>
	<tr id='row3'>
		<td id='c0-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c1-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c2-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c3-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c4-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c5-2' class='question'>$<?php echo $v * 3; ?></td>
	</tr>
	<tr id='row1'>
		<td id='c0-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c1-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c2-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c3-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c4-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c5-3' class='question'><?php echo $v * 4; ?></td>
	</tr>
	<tr id='row1'>
		<td id='c0-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c1-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c2-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c3-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c4-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c5-4' class='question'><?php echo $v * 5; ?></td>
	</tr>
</table>