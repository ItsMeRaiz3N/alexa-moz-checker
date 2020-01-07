<title>Alexa Rank Checker!</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=0.5">
<meta name="Description" content="Single Alexa Rank Checker | Jakarta Paranoid">
<meta property="og:image" content="https://images.wallpaperscraft.com/image/anime_girl_gothic_eyes_red_15108_1024x768.jpg"/>
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
size: 2px;
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
h1 {
color: white;
}
</style>
<body>
<center>
<h1>Alexa Rank Checker</h1>
</center>
</body>
<center>
<?php
 function get_rank($domain){
 $url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$domain;
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_URL, $url);
 $data = curl_exec($ch);
 curl_close($ch);
 $xml = new SimpleXMLElement($data);
 if($popularity = @$xml->xpath("//POPULARITY"))
 {
 $rank = $popularity[0]['TEXT'];
 }else
 {
 $rank = 'UnRanked!';
 }
 return $rank;
 }
 echo '<center>';
 echo '
 <form method="post">
 <center>
 <textarea name="url" rows="1" cols="60" placeholder="yoursite.co.li"></textarea><p>
 <input type="submit" value="check!" name="submit" />';
 echo '<p></form>';
 if (isset($_POST['submit']))
 {
 $list= htmlspecialchars($_POST['url']);
 echo '< Your Site ><br>';
 echo '<font color=lime>';
 $array=explode("\n",$list);
 for($i=0;$i<count($array);$i++)
 {
 $A=get_rank($array[$i]);
 echo $array[$i].'</font><p>< Global Rank ><br><font color=lime>'.$A.'</font><hr width=100px><br/>';
 echo 'Want to check DA,PA to? <a href="https://tools.jakartaparanoid.com/seo/mozrank/">Click Here!</a>';
 echo '</font>';
 }
 }
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
$ipaddress = $_SERVER['REMOTE_ADDR'];
echo "<center>";
echo "<p><br>Your IP:<br>";
echo IPnya();
echo "</center>";

?>