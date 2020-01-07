<title>MozRank Checker!</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=0.5">

<meta name="Description" content="DA,PA Checker | Jakarta Paranoid">
<meta property="og:image" content="http://ia.media-imdb.com/images/rock.jpg" />
<link rel="icon" type="image/png" href="https://images.wallpaperscraft.com/image/anime_girl_gothic_eyes_red_15108_1024x768.jpg">
</head>
<style>
body {
margin: 100px;
background:#000000;
background-size: cover;
background-repeat: no-repeat;
color:#FFFFFF;
font-family: Montserrat ;
}
textarea {
background:transparent;
color:#FFFFFF;
margin:4px;
padding:5px;
border:1px solid #FFFFFF;
font-family: Montserrat ;
}
input[type=submit] {
background:transparent;
color:#FFFFFF;
border:1px solid #FFFFFF;
font-family: Montserrat ;
}
a {
text-decoration: none;
color: white;
}
</style>
<center>
<h1>MozRank Checker</h1>
<form method="post">
<textarea name="url_form" cols="40" rows="8" placeholder="https://127.0.0.1/" style="width: 475px">
<?=htmlspecialchars($_REQUEST['url_form']);?>
</textarea >
<br /><br>
<input type="submit" style="margin-top: 5px; font-size: 18px" value="Check Metrics" />
</form>
</center>
<?php
function IPnya() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP Tidak Dikenali';
 
    return $ipaddress;
}

if($_REQUEST['url_form']) {
$urls = trim(htmlspecialchars($_POST['url_form']));
$urls = explode("\n", $urls);
$urls = array_filter($urls, 'trim');
}
if(!$urls) {
exit;
}
?>
<div style="margin: auto; width: 525px; min-width: 525px">
<table width="525" cellpadding="5" cellspacing="5" style="text-position: left">
<thead style="text-align: left">
<tr><th>ID</th><th>URL</th><th>DA</th><th>PA</th><th>MR</th><th>EL</th></tr></thead>
<tbody>
<?php
$hitung = 0;
$urlx = array();
$verif_url = array_chunk($urls,80);
foreach($verif_url as $chunk) {
sleep(2);
unset($url);
$url = $chunk;
$seo = API_MOZ($url);
if($seo['error'] != '') {
echo "Error[SEOMoz]: ".$seo['error']."<br>";
} else {
foreach($seo as $index => $data) {
$urls['pa'] = number_format($data['pa'], 0, '.', '');
$urls['url'] = $data['url'];
$urls['da'] = number_format($data['da'], 0, '.', '');
$urls['title'] = $data['title'];
$urls['external_links'] = $data['external_links'];
$urls['mozrank'] = number_format($data['mozrank'], 2, '.', '');
$hitung++;
echo "<tr><td>";
echo $hitung;
echo "</td><td>";
echo str_replace("http://","",$urls['url']);
echo "</td><td>";
echo $urls['da'];
echo "</td><td>";
echo $urls['pa'];
echo "</td><td>";
echo $urls['mozrank'];
echo "</td><td>";
echo $urls['external_links'];
echo "</td>";
echo "</tr>";
$urlx[] = $urls;
}
}
}

?>
</tbody></table>
<br><br><center>
Want to check Alexa Rank to?<a href="https://tools.jakartaparanoid.com/seo/alexacheck/"> Click Here!</a>
<?php
$ipaddress = $_SERVER['REMOTE_ADDR'];
echo "<center>";
echo "<p>Your IP:<br>";
echo IPnya();

$_SESSION['urlx'] = htmlspecialchars($urlx);
if(!empty($urlx)) { }
?>
</center>
</div>
<?php
// Document code by Moz
// www.stateofdigital.com
function API_MOZ($objectURL) {
// cek https://moz.com/products/api/keys untuk mendapatkan accessID dan secretKey nya
// your accessID
$accessID = "mozscape-16649d58c5";
// your secretKey
$secretKey = "75fff26b7423a1642cb148e71625284c";
$expires = time() + 600;
$stringToSign = $accessID."\n".$expires;
$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
$urlSafeSignature = urlencode(base64_encode($binarySignature));
$cols = 68719476736+34359738368+536870912+32768+16384+2048+32+4;
$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
$batchedDomains = $objectURL;
$encodedDomains = json_encode($batchedDomains);
$options = array(CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS =>$encodedDomains);
$ch = curl_init($requestUrl);
curl_setopt_array($ch, $options);
$content = curl_exec($ch);
curl_close( $ch );
$response = json_decode($content,true);
$count = 0;
if(isset($response['error_message'])) {
$list = array('error'=>htmlspecialchars($response['error_message']));
} else {
foreach($response as $metric) {
$list[$count]['url'] = $objectURL[$count];
$list[$count]['subdomain'] = $metric['ufq'];
$list[$count]['domain'] = $metric['upl'];
$list[$count]['pa'] = $metric['upa'];
$list[$count]['da'] = $metric['pda'];
$list[$count]['mozrank'] = $metric['umrp'];
$list[$count]['title'] = $metric['ut'];
$list[$count]['external_links'] = $metric['ueid'];
$count++;  
}
}
return $list;	
}

?>