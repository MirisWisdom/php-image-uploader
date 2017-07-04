<?php
require_once 'Image.php';
require_once 'ImageValidation.php';
require_once 'ImageStatus.php';

if (isset($_FILES['image'])) {
    // Let's create an instance of the image and the validator!
    $uploadedImage = new Image($_FILES['image']);
    $imageValidation = new ImageValidation($uploadedImage);

    // Error when file size is bigger than maximum or file doesn't have compatible extension.
    if ($imageValidation->getFileStatus() == ImageStatus::FileError) {
        echo "Please ensure that the image is a PNG or JPEG under 2MB!";
        return;
    }

    // Error when the contents of the file are not PNG or JPEG.
    if ($imageValidation->getDataStatus() == ImageStatus::DataError) {
        echo "Image data verification failed. It seems that this file isn't a valid image!";
        return;
    }

    // Well, if no errors have occurred... we can upload the file!
    uploadSuccess($uploadedImage->getTempName(), $uploadedImage->getRealName());
}

// Success!
function uploadSuccess($file_tmp, $file_name) {
	
    // Give the file a name, and upload it to the desired directory.
    // Using date, md5(rand()) twice and the original file name to generate an unique name.
	
    $filename = time() . "-" . substr(md5(rand()), 0, 7) . "-" . substr(md5(rand()), 0, 7) . "-" . $file_name;
    move_uploaded_file($file_tmp, "images/" . $filename);
	
    echo "Success!";
}

?>

<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="image" />
         <input type="submit"/>
      </form>
      
   </body>
</html>
