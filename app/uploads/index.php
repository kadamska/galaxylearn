<?php

$UploadDirectory  = 'files/'; //Upload Directory, ends with slash & make sure folder exist

require_once('ImageManipulator.php');

/*
$im = new ImageManipulator('/path/to/image');
$centreX = round($im->getWidth() / 2);
$centreY = round($im->getHeight() / 2);

$x1 = $centreX - 100;
$y1 = $centreY - 65;

$x2 = $centreX + 100;
$y2 = $centreY + 65;

$im->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
$im->save('/path/to/cropped/image');
*/

if (!@file_exists($UploadDirectory)) {
    //destination folder does not exist
    die("Make sure Upload directory exist!");
}


    if(!isset($_FILES['uploadedFile']))
    {
        //required variables are empty
        die("File is empty!");
    }


    if($_FILES['uploadedFile']['error'])
    {
        //File upload error encountered
        die(upload_errors($_FILES['uploadedFile']['error']));
    }

    $FileName           = strtolower($_FILES['uploadedFile']['name']); //uploaded file name
    $ImageExt           = substr($FileName, strrpos($FileName, '.')); //file extension
    $FileType           = $_FILES['uploadedFile']['type']; //file type
    $FileSize           = $_FILES['uploadedFile']["size"]; //file size
    $RandNumber         = rand(0, 9999999999); //Random number to make each filename unique.
    $uploaded_date      = date("Y-m-d H:i:s");

    switch(strtolower($FileType))
    {
        //allowed file types
        case 'image/png': //png file
        case 'image/gif': //gif file
        case 'image/jpeg': //jpeg file
        case 'image/jpg': //jpg file
            break;
        default:
            die('Unsupported File!'); //output error
    }

    //File Title will be used as new File name
    $NewFileName = preg_replace(array('/s/', '/.[.]+/', '/[^w_.-]/'), array('_', '.', ''), strtolower($FileTitle));
    $NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;
   //Rename and save uploded file to destination folder.
   if(move_uploaded_file($_FILES['uploadedFile']["tmp_name"], $UploadDirectory . $NewFileName ))
   {

        $im = new ImageManipulator($UploadDirectory.$NewFileName);
        $centreX = round($im->getWidth() / 2);
        $centreY = round($im->getHeight() / 2);

        $x1 = $centreX - 150;
        $y1 = $centreY - 125;

        $x2 = $centreX + 150;
        $y2 = $centreY + 125;

        $im->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
        $im->save($UploadDirectory.$NewFileName);

        $image_url = 'http://' . $_SERVER['SERVER_NAME'] . 
        dirname($_SERVER['PHP_SELF']).'/'.$UploadDirectory.$NewFileName;
        list($width, $height) = getimagesize($UploadDirectory.$NewFileName);
        $json = array();
        $json['path']  = $image_url;
        $json['width'] = $width;
        $json['height'] = $height;

        die(json_encode($json));
        //die('Success! File Uploaded.');

   }else{
        die('error uploading File!');
   }



//function outputs upload error messages, http://www.php.net/manual/en/features.file-upload.errors.php#90522
function upload_errors($err_code) {
    switch ($err_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}