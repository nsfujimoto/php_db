<html>
<meta charset="utf-8">

<?php
   ini_set("display_errors", 1);
   $upload_dir = "/var/www/html/Blog/image";
   $tmp_name = $_FILES["picture"]["tmp_name"];
   $name = $_POST["pic_name"];
   move_uploaded_file($tmp_name, "$upload_dir/$name");
?>


</html>