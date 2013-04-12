#!/bin/bash -       
#title			:login.sh
#description	:Log in the image hoster abload.de
#author			:Bubelbub <bubelbub@gmail.com>
#date			:20130412
#version		:1.0
#github			:http://github.com/Bubelbub/Abload.de-Tools
#==============================================================================

# check if parameter 1 is a username, parameter 2 is a password
if [ "$1" == "" ] || [ "$2" == "" ]; then
	echo "Please use $0 username password"
	exit 0
fi

# upload the image
RESPONSE=`curl -s -F "name=$1" -F "password=$2" -F "cookie=on" -b cookies.txt -c cookies.txt http://www.abload.de/login.php?next=/`

if [[ $RESPONSE =~ 'login_php' ]]; then
	echo "Login failed"
else
	echo "Logged in successfully"
fi
