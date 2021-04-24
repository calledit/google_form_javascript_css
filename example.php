<?php
//the url to the google form
$_GET['url'] = 'https://docs.google.com/forms/d/e/1FAIpQLScJCYDMZB9jAAmlO5OIx740nWg3WrVDrkb9nL8XF1_BE9b-Vg/viewform';
include("index.php");//include the google form 
?>
<style>
  /* make the backgound white*/
.freebirdLightBackground,body{
    background-color: white !important
}
  /*Hide banners*/
.freebirdFormviewerViewFooterDisclaimer,
	.freebirdFormviewerViewFooterPageBreak,
	.freebirdFormviewerViewHeaderThemeStripe,
	.freebirdFormviewerViewFeedbackSubmitFeedbackButton,
	.freebirdFormviewerViewNavigationPasswordWarning{
    display: none !important
}
</style>
<script>
  //Show alert buttons when the user tries to continue to the next page
setTimeout(function(){
	var navigator_buttons = document.querySelectorAll('.freebirdFormviewerViewNavigationNoSubmitButton');
	for(i=0;i<navigator_buttons.length;i++){
		navigator_buttons[i].onclick = function() { alert('user pressed the next/back button'); };
	}
},1000);
</script>
