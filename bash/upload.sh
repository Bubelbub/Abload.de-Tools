#!/bin/bash -       
#title			:upload.sh
#description	:This script uploads a image to the image hoster abload.de
#author			:Bubelbub <bubelbub@gmail.com>
#date			:20130412
#version		:1.1
#github			:http://github.com/Bubelbub/Abload.de-Tools
#==============================================================================

# check if parameter 1 is a file
if [ "$1" == "" ] || [ ! -f $1 ]; then
	echo "Parameter 1 should be a (image) file."
	exit 0
fi

# upload the image
RESPONSE=`curl -F "img0=@$1" -s -b cookies.txt -c cookies.txt http://www.abload.de/upload.php`

# grab the key
KEY=`grep -Po '(?<=name="key" value=")([A-Za-z0-9]+)(?=")' <<< $RESPONSE`

# get the image list in html format
IMAGESHTML=`curl -s -b cookies.txt -c cookies.txt "http://www.abload.de/uploadComplete.php?key=$KEY"`

# get the links in plain format
IMAGES=`grep -Po '(?<=")http://www.abload.de/image.php\?img=([A-Za-z0-9.,% -]+)(?=")' <<< $IMAGESHTML`

# output the links
echo "Uploaded images links:"
for IMAGE in $IMAGES
do
	echo $IMAGE
done
