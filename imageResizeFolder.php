<?php
//Maximize script execution time
ini_set('max_execution_time', 0);

//Initial settings, Just specify Source and Destination Image folder.
$ImagesDirectory    = 'images/uploadstemp/'; //Source Image Directory End with Slash
$DestImagesDirectory    = 'images/uploads/'; //Destination Image Directory End with Slash
$NewImageWidth      = 500; //New Width of Image
$NewImageHeight     = 500; // New Height of Image
$Quality        = 80; //Image Quality

//Open Source Image directory, loop through each Image and resize it.
if($dir = opendir($ImagesDirectory)){
    while(($file = readdir($dir))!== false){

        $imagePath = $ImagesDirectory;
        $destPath = $DestImagesDirectory;
       // $checkValidImage = @getimagesize($imagePath);

        if(file_exists($imagePath)) //Continue only if 2 given parameters are true
        {
            
            if(resize_img($imagePath, $destPath, $file, 700)) {
                 echo 'Image processed and saved.';
                 // add your database code here
            } else {
                 echo 'Cannot process image.';
            } 


           //Image looks valid, resize.
          //  if(resizeImage($imagePath,$destPath,$NewImageWidth,$NewImageHeight,$Quality))
          //  {
           //     echo $file.' resize Success!<br />';
                /*
                Now Image is resized, may be save information in database?
                */

          //  }else{
          //      echo $file.' resize Failed!<br />';
          //  }
        }
    }
    closedir($dir);
}

//Function that resizes image.
 function resize_img($dir_in, $dir_out, $imedat='defaultname.jpg', $max=250) {

   $img = $dir_in . '/' . $imedat;
   $tmp = explode('.', $imedat);
   $extension = end($tmp);

   switch ($extension){
   
         case 'jpg':
         case 'jpeg':
         $image = ImageCreateFromJPEG($img);
         break;
               
         case 'png':
         $image = ImageCreateFromPNG($img);
         break;
               
         default:
         $image = false;
   }


if(!$image){
      // not valid img stop processing
      return false; 
}

 $vis = imagesy($image);
 $sir = imagesx($image);

  if(($vis < $max) && ($sir < $max)) {
     $nvis=$vis; $nsir=$sir;
  } else {
    if($vis > $sir) { $nvis=$max; $nsir=($sir*$max)/$vis;}
    elseif($vis < $sir) { $nvis=($max*$vis)/$sir; $nsir=$max;}
    else { $nvis=$max; $nsir=$max;}
  }

      $out = ImageCreateTrueColor($nsir,$nvis);
      ImageCopyResampled($out, $image, 0, 0, 0, 0, $nsir, $nvis, $sir, $vis);

   switch ($extension){
   
         case 'jpg':
         case 'jpeg':
         imageinterlace($out ,1);
         ImageJPEG($out, $dir_out . '/' . $imedat, 75);
         break;
               
         case 'png':
         ImagePNG($out, $dir_out . '/' . $imedat);
         break;
               
         default:
         $out = false;
   }
   
   if(!$out){
         return false;
   }
   
ImageDestroy($image);
ImageDestroy($out);

return true;
}

?>