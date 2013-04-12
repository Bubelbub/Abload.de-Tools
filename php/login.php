<?php

/**
 * @author Bubelbub <bubelbub@gmail.com>
 * @version 1.0.0
 */

$username	 = ''; // Insert your username here // hier kommt dein Benutzername hin
$password	 = ''; // Insert your password here // hier kommt dein Passwort hin

$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'http://www.abload.de/login.php?next=/');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$post = array(
	'cookie'	 => 'on',
	'name'		 => $username,
	'password'	 => $password
);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

$response = curl_exec($ch);
