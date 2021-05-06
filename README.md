# google_form_javascript_css
System to embed css and javascript in to a google form

php scripts that allows adding custom stylesheats and custom javascript to
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
* Detecting when users fill out questions but dont submit the from.


## Usage
Upload **index.php, example.php and proxy.php** to a webserver that supports php.
To add CSS and javascript to your google form edit the example.php file

### Example
Showing some basic CSS styling, hiding questions and filling out some questions with infromation such as the userAgent
```php
<?php
if(!isset($_GET['url'])){
	//the url to the google form
	$_GET['url'] = 'https://docs.google.com/forms/d/e/1FAIpQLSdF2sUM_3WkdMgtEBd2NlSgKrVdhMMtHJ5_zjOtURrTCootCQ/viewform';
}
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
	var PageLoadTime = new Date();

	//Create an index of the questions on this page
	var Question_Index = {};
	var Questions = document.querySelectorAll('.exportItemTitle');
	for(i=0;i<Questions.length;i++){
		Question_Index[Questions[i].childNodes[0].nodeValue] = Questions[i].parentElement.parentElement.parentElement.parentElement.parentElement;
	}


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

	//function to set or get the value of a question
	function question_val(question, value, overwrite){
		if(typeof(Question_Index[question]) == 'undefined'){
			return false;
		}
		var input = Question_Index[question].querySelector('input');
		var current_val = input.value;
		if(typeof(value) == 'undefined'){
			return current_val;
		}
		if(overwrite || current_val == ""){
			if(typeof(value) == 'function'){
				value = value(current_val);
			}
			input.value = value;
			input.dispatchEvent(new Event('input', {bubbles: true, cancelable: true}));
		}
	}
</script>
```
