<?php
//$c=<<<EOD
if(isset($_POST['growth_submit'])){
	var_dump($_POST);
	$id = $_POST['identifier'];
	$v = $_POST['data'];
	$bd =$_POST['birthdate'];;
	$gd =$_POST['gender'];;
}
else {
$v = array();
	$id = '';
	$gd = '';
	$bd ='';
}
	
?>
<form class="cmxform" id="dataForm" method="post" action="">
	<fieldset>
		<legend>Validating a complete form</legend>
		<p>
		<input id="identifier" value="<?php echo $id  ?>" name="identifier" type="text" />
			<label for="identifier">Child's identifier *( Name/Nickname.. used in the graph title)</label>
			
		</p>
		<p>
			
			<select name="gender" id="">
				<option <?php if($gd == 'm') echo 'selected="selected"' ?> value="m">Male</option>
				<option <?php if($gd == 'f') echo 'selected="selected"' ?> value="f">Female</option>
			</select>
			<label for="gender">Gender*</label>
		</p>
		<p>
			
			<input id="birthdate" value="<?php echo $bd  ?>" name="birthdate" type="text" />
			<label for="birthdate">Birthdate (recquired if dates rather than ages are used below)</label>
		</p>
		
		<!-- All entries -->
		
		<div id="entries_container">
		<!-- Entry 1  -->
<?php for($i=1; $i<4; $i++): ?>		
			<div class="entries" style="margin-bottom:30px;clear:both">
			<p>Entry# <?php echo $i?></p>
			<input type="text" <?php if($i<3) echo  "class='required'" ?> style="float:left;" name="data[<?php echo $i-1 ?>][0]" value ="<?php echo $v[$i-1][0] ?>" />
				<div style="float:left;">
					<input <?php if($i<3) echo  "class='required'" ?> type="radio" value='date' <?php if($v[$i-1][1] == 'date') echo 'checked="checked"' ?> name="data[<?php echo $i-1 ?>][1]" id="" /> 
					<label for="date[<?php echo $i-1 ?>][1]">Date</label> 
					<br/>
					<input type="radio" value='age' <?php if($v[$i-1][1] == 'age') echo 'checked="checked"' ?>  name="data[<?php echo $i-1 ?>][1]" id="" />
					<label for="date[<?php echo $i-1 ?>][1]">Age</label>
		
				</div>
			<div style="clear:both"></div>
			
			
			<div style="float:left">
				Weight
				<div style="clear:both"></div>
				<input type="text" style="float:left;" name="data[<?php echo $i-1 ?>][2]"  value="<?php echo $v[$i-1][2] ?>"/>
				<div style="float:left;">
						<input type="radio" <?php if($v[$i-1][3] == 'kg') echo 'checked="checked"' ?>  name="data[<?php echo $i-1 ?>][3]" value='kg' id="" /> 
						<label for="date[<?php echo $i-1 ?>][3]">Kg</label> 
						<br/>
						<input type="radio" <?php if($v[$i-1][3] == 'lb') echo 'checked="checked"' ?>  name="data[<?php echo $i-1 ?>][3]" value='lb' id="" />
						<label for="date[<?php echo $i-1 ?>][3]">Lb Oz</label>
				</div>
			</div>
				
				<div style="float:left;margin-left:20px">
					Height
					<div style="clear:both"></div>
				<input type="text" style="float:left;" name="data[<?php echo $i-1 ?>][4]"  value="<?php echo $v[$i-1][4] ?>"/>
					<div style="float:left;">
						<input type="radio" value='cm' <?php if($v[$i-1][5] == 'cm') echo 'checked="checked"' ?>  name="data[<?php echo $i-1 ?>][5]" id="" /> 
						<label for="date[<?php echo $i-1 ?>][5]">cm</label> 
						<br/>
						<input type="radio" value='in' <?php if($v[$i-1][5] == 'in') echo 'checked="checked"' ?>   name="data[<?php echo $i-1 ?>][5]" id="" />
						<label for="date[<?php echo $i-1 ?>][5]">in</label>
					</div>
				</div>
					
				<div style="float:left;margin-left:20px">
					Head Circumference
					<div style="clear:both"></div>
					<input type="text" style="float:left;" name="data[<?php echo $i-1 ?>][6]"  value="<?php echo $v[$i-1][6] ?>"/>					<div style="float:left;">
						<input type="radio" <?php if($v[$i-1][7] == 'cm') echo 'checked="checked"' ?>  value='cm' name="data[<?php echo $i-1 ?>][7]" id="" /> 
						<label for="date[<?php echo $i-1 ?>][7]">cm</label> 
						<br/>
						<input type="radio" value='in' <?php if($v[$i-1][7] == 'in') echo 'checked="checked"' ?>  name="data[<?php echo $i-1 ?>][7]" id="" />
						<label for="date[<?php echo $i-1 ?>][7]">in</label>
					</div>
					<div style="clear:both"></div>
				</div>
					
				<div style="clear:both"></div>
				
			</div><!-- end of entries -->
			<div style="clear:both"></div>
			
		<?php endfor; ?>
		</div><!-- end of entries container -->
			
			
		<p>
			<input class="submit" name='growth_submit' type="submit" value="Submit"/>
		</p>
	</fieldset>
</form>
<?php
//EOD;

//return $c;

