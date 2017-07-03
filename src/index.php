<?php
if (isset($_FILES['image'])) {
	
    // Variables
    $errors = array();
	
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
	
    $types = array('image/jpeg', 'image/png');
	
    define('KB', 1024);
    define('MB', 1048576);
    define('GB', 1073741824);
	
	
    // DEBUG
    // echo $_FILES['image']['name'] . $_FILES['image']['size'] . $_FILES['image']['tmp_name'];
	
	
    // LEVEL 1: Simple check
	
    // Check if it's an image by name
    if (!preg_match("/\.(jpe?g|png)\b/", $file_name)) {
        $errors[] = "Extension not allowed, please upload a PNG or JPEG file instead!";
    }
	
    // Check file fize
    if ($file_size > 2 * MB) {
        $errors[] = 'File size must be smaller than 2MB';
    }
	
    // END LEVEL 1
    if (empty($errors) == true) { // If it already has errors, then it doesn't need to run heavier scripts.
	
        // LEVEL 2: Deeper check
		
        // Check if it's an image using getimagesize
        if (!is_array(getimagesize($file_tmp))) {
            $errors[] = 'File failed the image check.';
        }
		
        // Now with exif_imagetype, just in case.
        // Even though it is the same as getimagesize, but returns faster.
        // Using exif twice to check the type, I wonder if it's good pratice...
        if (!exif_imagetype($file_tmp) && !in_array(exif_imagetype($file_tmp), $types)) {
            $errors[] = 'File is not an image.';
        }
		
		
        // END LEVEL 2
        
    }
	
	
	
    // All CHECKS DONE!
    // Let's see if it has any errors...
    if (empty($errors) == true) {
		
        // No errors!
        uploadSuccess($file_tmp, $file_name);
		
    } else {
		
        // Errors!
        printErrors($errors);
    }
}



// Success!
function uploadSuccess($file_tmp, $file_name) {
	
    // Give the file a name, and upload it to the desired directory.
    // Using date, md5(rand()) twice and the original file name to generate an unique name.
	
    $filename = time() . "-" . substr(md5(rand()), 0, 7) . "-" . substr(md5(rand()), 0, 7) . "-" . $file_name;
    move_uploaded_file($file_tmp, "images/" . $filename);
	
    echo "Success!";
}


// Failed...
// Print all the errors!
function printErrors($errors) {
    print_r($errors); // TODO: Make it print it properly 
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
