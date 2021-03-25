<?php
//What form should we mediate
$form_url = NULL;
if(isset($_GET['url'])){
	$form_url = $_GET['url'];
}else{
?>
<form>
url to google form:
<input type="text" name="url">
<input type="submit">
</form>
<?php
exit;
}

//Sumbmit the form to google
$curl_Session = curl_init();
curl_setopt($curl_Session, CURLOPT_URL, $form_url);
curl_setopt($curl_Session, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_Session, CURLOPT_SSL_VERIFYHOST, 0);
if(count($_POST) > 0){
	curl_setopt($curl_Session, CURLOPT_POSTFIELDS, $_POST);
}
$output = curl_exec($curl_Session);
curl_close($curl_Session);

//fix refernces to google so that the form stays of googles domains
$type = 'action';
$pts = explode(' '.$type.'="https://docs.google.com/forms/', $output);
if(count($pts) != 2){
	$type = 'href';
	$pts = explode(' '.$type.'="https://docs.google.com/forms/', $output);
}
if(count($pts) == 2){
	$spts = explode('"', $pts[1]);
	$url = 'https://docs.google.com/forms/'.array_shift($spts);
	$output = $pts[0].' '.$type.'="?url='.rawurlencode($url).'"'.implode('"', $spts);
}
?>
<script>
//Redirect XHR rexests to local proxy as google does not allow cross site XHR
(function (XHR) {
    var open = XHR.prototype.open;
    XHR.prototype.open = function (method, url, async, user, pass) {
        this._url = url;
        if (url.indexOf("gstatic.com") !== -1 ||
            url.indexOf("docs.google.com") !== -1) {
            url = "proxy.php?csurl=" + encodeURIComponent(url);
        }
        open.call(this, method, url, async, user, pass);
    };
})(XMLHttpRequest);
</script>
<?php

echo $output;

?>
