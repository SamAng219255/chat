<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?p=settings&place=replace">';};?>

<title>Settings</title>

<?php

require 'db.php';

if(isset($_POST['patnum'])) {
	$total="";
	$first=1;
	for($i=1; $i<=$_POST['patnum']; $i++) {
		if($_POST['pattwo'.$i]!='') {
			if($first==0) {
				$total.=json_decode('"\u001F"');
			}
			$first=0;
			$total.=$_POST['patone'.$i];
			$total.=json_decode('"\u001D"');
			$total.=$_POST['pattwo'.$i];
		}
	}
	$sql="UPDATE `chat`.`users` SET quirks='".addslashes($total)."' WHERE username='".$_SESSION['username_chat']."';";
	mysqli_query($conn,$sql);
}

?>

<div id="settingbox">
	<h1>Settings</h1>
	<hr>
	<form method="post">
	<div id="rows">
		<?php
			$query="SELECT `quirks` from `chat`.`users` where username='".$_SESSION['username_chat']."';";
			$queryresult=mysqli_fetch_row(mysqli_query($conn,$query))[0];
			$patterns=explode(json_decode('"\u001F"'), $queryresult);
			$patternslen=count($patterns);
			echo '<input type="hidden" value="'.$patternslen.'" id="patnum" name="patnum">';
			for($i=1; $i<=$patternslen; $i++) {
				$current=explode(json_decode('"\u001D"'), $patterns[$i-1]);
				if(count($current)>1) {
					echo '<div id="pat'.$i.'" class="patrow"><input type="text" value="'.$current[0].'" name="patone'.$i.'">=<input type="text" value="'.$current[1].'" name="pattwo'.$i.'"></div>';
				}
			}
			$patternslen++;
			echo '<div id="pat'.$patternslen.'" class="patrow"><input type="text" name="patone'.$patternslen.'">=<input type="text" name="pattwo'.$patternslen.'"></div>';
			
		?>
	</div>
	<div onclick="addrow()" class="bttn noselect">Add</div>
	<div onclick="removerow()" class="bttn noselect">Remove</div>
	<input type="submit" value="Save" style="float:right; width:50px; height: 37px; border-radius:0px;">
	</form>
	<script>
		patternslen=parseInt(document.getElementById("patnum").value);
		patternslen+=2;
		function addrow() {
			$("#rows").append('<div id="pat'+patternslen+'" class="patrow"><input type="text" name="patone'+patternslen+'">=<input type="text" name="pattwo'+patternslen+'"></div>');
			patternslen++;
			document.getElementById("patnum").value=patternslen;
		}
		function removerow() {
			patternslen--;
			$("#pat"+patternslen).remove();
			document.getElementById("patnum").value=patternslen;
		}
	</script>
</div>
