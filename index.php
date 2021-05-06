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
//Show form selection if we dont have a form
?>
<form>
url to google form:
<input type="text" name="url">
<input type="submit">
</form>
<?php
exit;
}

$context = array('http' => array());
//We force english otherwise the form forces us to use the server locations country
$context['http']['header'] = array("Accept-Language: en-US,en;q=0.8,aa;q=0.6\r\n");
//Sumbmit the form to google
if(count($_POST) > 0){
	$context['http']['method'] = 'POST';
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
            url = "index.php?proxy=1&url=" + encodeURIComponent(url);
        }
        open.call(this, method, url, async, user, pass);
    };
})(XMLHttpRequest);
</script>
<?php
}
echo $output;

?>
