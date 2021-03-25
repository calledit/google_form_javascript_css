<?php
include("index.php");
?>
<style>
.freebirdLightBackground,body{
    background-color: white !important
}
.freebirdFormviewerViewFooterDisclaimer,
	.freebirdFormviewerViewFooterPageBreak,
	.freebirdFormviewerViewHeaderThemeStripe,
	.freebirdFormviewerViewFeedbackSubmitFeedbackButton,
	.freebirdFormviewerViewNavigationPasswordWarning{
    display: none !important
}
</style>
<script>
setTimeout(function(){
	var navigator_buttons = document.querySelectorAll('.freebirdFormviewerViewNavigationNoSubmitButton');
	for(i=0;i<navigator_buttons.length;i++){
		navigator_buttons[i].onclick = function() { alert('user pressed the next/back button'); };
	}
},1000);
</script>
