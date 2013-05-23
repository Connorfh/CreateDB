<?php
/*
 * Entry point.
 */

require_once("config.inc.php");
 
?>

<?php require_once("header.tpl.php") ?>

<div class="centered"><h2>Create A Database</h2></div class>

Fill out the fields below to create a database on athena. Remember that the username and password are not necessarily the same as your Windows username and password.
<form id="form" action="">
	<fieldset>
		<div>
			<label for="username">Username</label>
			<input type="text" id="username" name="username" class="required" />
			<div class="error"></div>
		</div>
		<div>
			<label for="password">Password</label>
			<input type="password" id="password" name="password" class="required" />
			<div class="error"></div>
		</div>
		<div>
			<label for="purpose">Class</label>
			<input type="text" id="purpose" name="purpose" class="required" />
			<div class="error"></div>
		</div>
		<div>
			<label for="dbName">Database name</label>
			<input type="text" id="dbName" name="dbName" class="required" />
			<div class="error"></div>
		</div>
		<div class="centered">
			<!--<a href="#" id="submit">Create!</a>-->
			<input type="submit" id="submit" name="submit" value="Create!" />
		</div>
	</fieldset>
</form>

<div id="response" class="centered">
	<p class="error">
		
	</p>
</div>

<?php requir_once("footer.tpl.php") ?>