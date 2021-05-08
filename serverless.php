<?php

if(!isset($_GET['url'])){
//Show form to allow user to select form if we dont have a form
?>
<form>
url to google form:
<input type="text" name="url">
<input type="submit">
</form>
<?php
exit;
}
include("form.php");//include the google form 
?>
<script>
	if(typeof(Headers_Index['<html>']) != 'undefined'){
		Headers_Index['<html>'].style.display = 'none';
		var description = Headers_Index['<html>'].querySelector('.freebirdFormviewerViewItemsSectionheaderDescriptionText').innerText;
		document.write(description);
	}
</script>
