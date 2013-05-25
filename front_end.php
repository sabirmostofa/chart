<?php
$c=<<<EOD
<form class="cmxform" id="dataForm" method="post" action="">
	<fieldset>
		<legend>Validating a complete form</legend>
		<p>
		<input id="firstname" name="identifier" type="text" />
			<label for="identifier">Child's identifier *( Name/Nickname.. used in the graph title)</label>
			
		</p>
		<p>
			
			<select name="gender" id="">
				<option value="m">Male</option>
				<option value="m">Female</option>
			</select>
			<label for="gender">Gender*</label>
		</p>
		<p>
			
			<input id="birthdate" name="birthdate" type="text" />
			<label for="birthdate">Birthdate (recquired if dates rather than ages are used below)</label>
		</p>
		<div id="entries_container">
			<div class="entries" style="float:left;margin-right:20px">
			<p>Entry#1</p>
			<textarea style="float:left;" name="" id="" cols="10" rows="2"></textarea>
				<div style="float:left;">
				<input type="radio" name="date1" id="" /> 
				<label for="date1">Date</label> 
				<br/>
				<input type="radio" name="date1" id="" />
				<label for="age1">Age</label>
				</div>
			</div>
			
			<div class="entries" style="float:left;margin-right:20px">
			<p>Entry#1</p>
			<textarea style="float:left;" name="" id="" cols="10" rows="2"></textarea>
				<div style="float:left;">
				<input type="radio" name="date2" id="" /> 
				<label for="date1">Date</label> 
				<br/>
				<input type="radio" name="date2" id="" />
				<label for="age1">Age</label>
				</div>
			</div>
			
			<div class="entries" style="float:left;margin-right:20px">
			<p>Entry#3</p>
			<textarea style="float:left;" name="" id="" cols="10" rows="2"></textarea>
				<div style="float:left;">
				<input type="radio" name="date3" id="" /> 
				<label for="date1">Date</label> 
				<br/>
				<input type="radio" name="date3" id="" />
				<label for="age1">Age</label>
				</div>
			</div>
			
			
		<div>
		<div style="clear:both"></div>
		<p>
			<input class="submit" type="submit" value="Submit"/>
		</p>
	</fieldset>
</form>

EOD;

return $c;

