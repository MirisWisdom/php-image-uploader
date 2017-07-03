<?php
   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
	  
	  $types = array('image/jpeg', 'image/png');
	  
	  // DEBUG
	  // echo $_FILES['image']['name'] . $_FILES['image']['size'] . $_FILES['image']['tmp_name'] . $file_type=$_FILES['image']['type'];
	  
	  // LEVEL 1: Simple check
	  
	  
      // Check if it's an image by name
      if (!preg_match("/\.(jpe?g|png)\b/", $file_name)) {
      
         $errors[]="Extension not allowed, please choose a JPEG or PNG file.";
      }
	  
	  
      // Check file fize
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
		  
		  // LEVEL 2: Deeper check
		  
		  // Check if it's image using getimagesize
		  
		  if(!is_array(getimagesize($file_tmp))) {
			  
			 $errors[]='File failed the image check.';
		  }
		  
		  // Now with exif_imagetype, just in case.
		  // Although it is the same as getimagesize, but returns faster.
		  
		  if( !exif_imagetype($file_tmp)) {
			  
			$errors[]='File is not an image.';
		  }
		  
		 if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/".$file_name);
         echo "Success";
		 }else{ // Failed Level 2
			printerrors($errors);
		}
      }else{ // Failed Level 1
         printerrors($errors);
      }
	  
   }
  
 function printerrors($errors) {
	 print_r($errors);
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