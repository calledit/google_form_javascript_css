# google_form_javascript_css
System to embed css and javascript in to a google form

php scripts that enables one to add custom stylesheats and custom javascript to
a google form.


## Usage
Upload **index.php, example.php and proxy.php** to a webserver that supports php.
To add CSS and javascript to your google form edit the example.php file
```html
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
```
