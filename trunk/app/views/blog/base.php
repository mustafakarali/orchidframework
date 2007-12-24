<?
$app->library->cssm->addParticleTreeButtonCSS();
?>

<form method="post" action="<?=$baseurl;?>/blog/login">
	<h2>Login </h2>

		<table width="300px">
			<tr>
				<td width="100px">Username:</td>
				<td><input type="text" name="username" value="<?=$username;?>" /></td>
			</tr>
			<tr>
				<td width="100px">Password:</td>
				<td><input type="password" name="password" /></td>
			</tr>
			<?
			if (!empty($error) && $error!="success"){
				echo "<tr style='padding-top:10px;padding-bottom:10px;'><td>&nbsp;</td>";
				echo "	<td style='color:red;'>";
				echo "		{$error}	";
				echo "	<td>";
				echo "</tr>";
			}
			else if($error=="success")
			{
				echo "<tr style='padding-top:10px;padding-bottom:10px;'><td>&nbsp;</td>";
				echo "	<td style='color:green;'>";
				echo "		user successfully registered	";
				echo "	<td>";
				echo "</tr>";
			}
			?>
			<tr>
				<td width="100px">&nbsp;</td>
				<td style="padding-top:15px;" class="buttons">
				
					<button type="submit" class="positive">
					    <img src="http://particletree.com/examples/buttons/tick.png" alt=""> 
					    Login 
					
					</button>
					
					<a href='<?=$baseurl;?>/blog/register'>
					    <img src="http://particletree.com/examples/buttons/textfield_key.png" alt=""> 
					    Register
					</a>

				</td>
			</tr>
		</table>
</form>

