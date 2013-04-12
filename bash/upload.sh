#!/bin/bash -       
#title           :upload.sh
#description     :This script uploads a image to the image hoster abload.de
#author		     :Bubelbub <bubelbub@gmail.com>
#date            :20130412
#version         :1.0
#github          :http://github.com/Bubelbub/Abload.de-Tools
#==============================================================================

# check if parameter 1 is a file
if [ "$1" == "" ] || [ ! -f $1 ]; then
	echo "Parameter 1 should be a (image) file."
	exit 0
fi

# upload the image
RESPONSE=`curl -F "img0=@$1" http://www.abload.de/upload.php 2>&1`

# grab the key
KEY=`grep -Po '(?<=name="key" value=")([A-Za-z0-9]+)(?=")' <<< $RESPONSE`

# get the image list in html format
IMAGESHTML=`curl "http://www.abload.de/uploadComplete.php?key=$KEY" 2>&1`

# get the links in plain format
IMAGES=`grep -Po '(?<=")http://www.abload.de/image.php\?img=([A-Za-z0-9.,% -]+)(?=")' <<< $IMAGESHTML`

# output the links
echo "Uploaded images links:"
for IMAGE in $IMAGES
do
	echo $IMAGE
done
