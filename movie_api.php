<?php

$counter = 1;

getmovie:

$curl = curl_init();
$url = 'https://api.themoviedb.org/3/discover/movie?api_key=a0acb84bc12a6a187fbf5cf4431ea867';
if(!empty($_GET['page'])){
	$url = 'https://api.themoviedb.org/3/discover/movie?api_key=a0acb84bc12a6a187fbf5cf4431ea867&page='.$_GET['page'];
}

curl_setopt_array($curl, array(
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
if(!empty($response)){
	echo $response;
	return;
}else{
    $counter++;
    if($counter > 5){
        return;
    }
	goto getmovie;
}


?>