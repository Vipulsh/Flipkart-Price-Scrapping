<?php
 
$url = "http://www.flipkart.com/digital-fortress-english/p/itme9byad7zkhzff?q=Digital+Fortress+%28English%29&as=on&as-show=on&otracker=start&as-pos=p_2_digital+fo&pid=9780552151696";
 
$response = getPriceFromFlipkart($url);
 
echo json_encode($response);
 
/* Returns the response in JSON format */
 
function getPriceFromFlipkart($url) {
 
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 10.10; labnol;) ctrlq.org");
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$html = curl_exec($curl);
	curl_close($curl);
 
	$regex = '/<meta itemprop="price" content="([^"]*)"/';
	preg_match($regex, $html, $price);
 
	$regex = '/<h1[^>]*>([^<]*)<\/h1>/';
	preg_match($regex, $html, $title);
 
	$regex = '/data-src="([^"]*)"/i';
	preg_match($regex, $html, $image);
 
	if ($price && $title && $image) {
	$response = array("price" => "Rs. $price[1].00", "title" => $title[1]);
	} else {
	$response = array("status" => "404", "error" => "We could not find the product details on Flipkart $url");
	}
 
	return $response;
}