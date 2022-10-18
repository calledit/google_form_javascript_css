<?php
$ok_domains = array(
	'gstatic.com',
	'ssl.gstatic.com',
	'docs.google.com',
	'www.gstatic.com',
	'www.ssl.gstatic.com',
	'www.docs.google.com'
);
$form_url = NULL;
if(isset($_GET['url'])){
	$form_url = $_GET['url'];
	$parsed_url = parse_url($form_url);
	if(!in_array($parsed_url['host'], $ok_domains)){
		exit;//exit if non approved url
	}
}else{
exit;
}

$context = array('http' => array());
//We force english otherwise the form forces us to use the server locations country
$context['http']['header'] = "Accept-Language: en-US,en;q=0.8,aa;q=0.6\r\n";
$context['http']['header'] .= "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.1 Safari/605.1.15\r\n";
//Sumbmit the form to google
if(count($_POST) > 0){
	$context['http']['method'] = 'POST';
	$context['http']['header'] .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$context['http']['content'] = http_build_query($_POST);
}
$context = stream_context_create($context);
$output = file_get_contents($form_url, false, $context);

//replace links to google so that the form stays of googles domains
$types = array(
	'action',
	'href',
	'HREF'
);
foreach($types AS $tp){
	$type = $tp;
	$pts = explode(' '.$type.'="https://docs.google.com/forms/', $output);
	if(count($pts) == 2){
		break;
	}
}
if(count($pts) == 2){
	$spts = explode('"', $pts[1]);
	$url = 'https://docs.google.com/forms/'.array_shift($spts);
	$output = $pts[0].' '.$type.'="?url='.rawurlencode($url).'"'.implode('"', $spts);
}
if(!isset($_GET['proxy'])){
?>
<script>
//Redirect XHR rexests to local proxy as google does not allow cross site XHR
(function (XHR) {
    var open = XHR.prototype.open;
    var send = XHR.prototype.send;
    XHR.prototype.send = function (body) {
		if(!this._fail){
			send.call(this, body);
		}
	};
    XHR.prototype.open = function (method, url, async, user, pass) {
		this._fail = false;
		if(url[0] == '/'){
			//The requests without domain requires cookies and we dont have the cookies, the form works anyway so we just ignore those requests
			this._fail = true;
		}
        this._url = url;
        if (url.indexOf("gstatic.com") !== -1 ||
            url.indexOf("docs.google.com") !== -1) {
            url = "?proxy=1&url=" + encodeURIComponent(url);
        }
        open.call(this, method, url, async, user, pass);
    };
})(XMLHttpRequest);
</script>
<?php
}
echo $output;

if(isset($_GET['proxy'])){
	exit;
}
?>
<script>

//Create an index of the questions on this page
var Question_Index = {};
var Headers_Index = {};

//Each item of a google form is in a div
var Questions = document.querySelectorAll('[role="listitem"]');
for(i=0;i<Questions.length;i++){
	
	//If the item has a question it has data-params
	var question_holder = Questions[i].querySelector('[data-params]');
	if(question_holder){
		var title_holder = question_holder.querySelector('[role="heading"]');
		if(title_holder){
			if(title_holder.childNodes[0]){
				Question_Index[title_holder.childNodes[0].innerText] = Questions[i];
			}else{
				console.error("Could not find question text span");
			}
		}else{
			console.error("Could not find question text");
		}
	}else{
		//sometimes header items gets a heading role sometimes they just contain a span
		var title_holder = Questions[i].querySelector('[role="heading"]');
		if(!title_holder){
			title_holder = Questions[i].querySelector('span');
		}
		if(title_holder){
			var header_text = title_holder.innerText
			Headers_Index[header_text] = Questions[i];
		}
	}
}

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
