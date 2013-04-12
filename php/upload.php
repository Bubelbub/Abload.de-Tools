<?php

/**
 * @author Bubelbub <bubelbub@gmail.com>
 * @version 1.0.0
 * 
 * If you would use galleries or save your images into your account: log in
 * -> login.php
 */

// define the array for images to upload
$imagesToAbload = array(
	'Koala.jpg', // example windows koala image in the same directory
	'C:/Users/Public/Pictures/Sample Pictures/Chrysanthemum.jpg' // example windows chrysanthemum image
);

// define the rest of post - for example a gallery id or resize
$post = array(
	'resize'	 => 'none', // example: 800x600, 1080, none
	'gallery'	 => 'null' // example: 11334, 12398, null
);

// convert images to curl format
for ($x = 0; $x < count($imagesToAbload); $x++)
{
	$post['img' . $x] = substr($imagesToAbload[$x], 0, 1) == '@' ? $imagesToAbload[$x] : '@' . $imagesToAbload[$x];
}

$ch			 = curl_init(); // initialize curl
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'http://www.abload.de/upload.php');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); // use cookies for login (not needed)
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); // use cookies for login (not needed)
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$response	 = curl_exec($ch);

$key = '';

/* @var $dom DOMDocument */
$dom = new DOMDocument;
$dom->loadHTML($response);
foreach ($dom->getElementsByTagName('input') as $elem)
{
	/* @var $elem DOMElement */
	if ($elem->hasAttribute('name') && $elem->hasAttribute('value'))
	{
		if (preg_match('#^key$#i', $elem->getAttribute('name')))
		{
			$key = $elem->getAttribute('value');
		}
	}
}
unset($dom);

$ch			 = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'http://www.abload.de/uploadComplete.php?key=' . urlencode($key));
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); // use cookies for login (not needed)
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); // use cookies for login (not needed)
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response	 = curl_exec($ch);

$images = array();

/* @var $dom DOMDocument */
$dom = new DOMDocument;
$dom->loadHTML($response);
foreach ($dom->getElementsByTagName('table') as $elem)
{
	/* @var $elem DOMElement */
	if ($elem->hasAttribute('class'))
	{
		if (preg_match('#^image_links$#i', $elem->getAttribute('class')))
		{
			$images[] = $elem->getAttribute('id');
		}
	}
}

$links = '';
foreach ($images as $image)
{
	$tmp	 = explode('_', $image);
	$links[] = 'http://www.abload.de/image.php?img=' . $tmp[1] . '.' . $tmp[2];
}

var_dump($links);
