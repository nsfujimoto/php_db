<html>
<meta charset="utf-8">
<body>
<?php
    require("../Album_db.php");
   ini_set("display_errors", 1);
   $upload_dir = "../../image";
   $upload_url = "/Blog/image";
   $tmp_name = $_FILES["picture"]["tmp_name"];

   $extension = explode(".", $_FILES["picture"]["name"]);
   $extension = $extension[count($extension)-1];

   $file_name = date("YmdHis") . "." . $extension;
   $name = $_POST["pic_name"];
   $db = new album_db();
    
   if(!$db->check_unique_url("$upload_url/$file_name")){ 
       echo "エラー：同一ファイルが存在します";
   }else{
    if(move_uploaded_file($tmp_name, "$upload_dir/$file_name")){
        try{
            $db->add_photos("$upload_url/$file_name", $name);
        }catch(Exception $ex){
            die("エラー:". $ex->getMessage());
        }
?>

    投稿成功<br>
    name:<?=$name?><br>
    <img src="../../image/<?=$file_name?>" alt=""><br>
<?php
   }else{
?>
    投稿失敗<br>

<?php 
}
   } 
?>
</body>
</html>
