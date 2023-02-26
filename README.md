# google_form_javascript_css
System to embed css and javascript in to a google form

Allows adding custom stylesheats and custom javascript to
a google form.

### This is useful for
* hiding questions
* capturing which browser the user is using
* capturing how large the users screen is
* capturing how long time the user took to fill out the form
* try to stop users from submiting the form more than one time.
* Setting time limts on the google form.
* Customizing the look and style of the form.
* Hiding or showing questions based on earlier answerd questions.
* Adding tracking to google forms like google analytics.
* Detecting when users fill out questions but dont submit the form.


## Usage
Upload **form.php and example.php** to a webserver that supports php.

**Edit example.php and change the "google form" url**, to the "google form" that you want to change styling on.

Then you can add CSS and javascript to the example.php file.

```javascript
//The library adds one javascript convience function called
question_val(
	question	/*(string) The exact name of the question*/,
	value		/*(string or function) What you want the default value to be, can be a value or a function (that will be called when the question is loaded)*/
	overwrite	/*(bool) if we are to write over the question if the form loads with a saved answer*/
	);
	
//The library also adds two global javascript variables Question_Index and Headers_Index which contain the dom elements of all questions and headers.
```

## Example
Showing some basic CSS styling, hiding questions and filling out some questions with infromation such as the userAgent

```php
<?php

if(!isset($_GET['url'])){
	//the url to the google form
	$_GET['url'] = 'https://docs.google.com/forms/d/e/1FAIpQLSdz63Nn6HJw7h2SSJT88-3R63VBq0g7-K4f1xqUSzTykWkRgg/viewform';
}
include("form.php");//include the google form 
?>
<style>
  /* make the backgound white*/
.freebirdLightBackground,.freebirdSolidBackground,body{
	background-color: white !important;
	color: black !important;
}
body{
	background-image: url('https://lh6.googleusercontent.com/Hg_pKUt7zv8FUokb5DMz0h88wR52H_6yREYm8Ei-zftGJBfnS4ym3mmBCxdFskA0dpA8t6IHSt5f3F_5n4uo4Uv8bp7AsatykB_8z2rPaFqOK-mJ0BlDSYHonBf5I88tfg=w740');
	background-size: cover;
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
	var PageLoadTime = new Date();

	//Hide questions that end in _hidden
	for(question in Question_Index){
		if(question.substr(question.length-7) == '_hidden'){
			Question_Index[question].style.display = 'none';
		}
	}

	//Set dynamic default value of questions
	question_val('form_open_time_hidden', PageLoadTime.toISOString(), false);
	question_val('form_random_loading_id_hidden', Math.floor(Math.random() * 1000000), false);
	question_val('user_agent_hidden', navigator.userAgent, false);
	question_val('screen_width_hidden', screen.width, false)
	question_val('screen_height_hidden', screen.height, false);
	question_val('form_page2_open_time_hidden', PageLoadTime.toISOString(), false);

</script>
```
