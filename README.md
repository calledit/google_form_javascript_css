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


## Using the severless inline css/javascript live demo (demo removed due to missuse)
On the live demo severless page: https://psyched-scene-312917.ew.r.appspot.com/serverless.php use the example form:
```
https://docs.google.com/forms/d/e/1FAIpQLSfyFYo38iB9qKOZxnTCJGlH-A6yBg_l1excYRv6gMz5mAosiQ/viewform
```


to create your own serverless css/javascript form, create a text section in your form with
the heading &lt;html&gt; and fill it with your css/javascript (see picture). After that you can use your own styled form with the serverless live demo. 
Each page of the form needs its own &lt;html&gt; section, you can use that to style each page of the form differently.

<img src="https://raw.githubusercontent.com/calledit/google_form_javascript_css/master/google_form_serverless_2021.png" alt="screenshot of form with inline js" width="50%"/>

## Using your own server
Upload **form.php and example.php** to a webserver that supports php.
To add CSS and javascript to your google form edit the example.php file

## Example
Showing some basic CSS styling, hiding questions and filling out some questions with infromation such as the userAgent

Live demo hosted on google app engine https://psyched-scene-312917.ew.r.appspot.com/example.php (demo removed due to missuse)
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
