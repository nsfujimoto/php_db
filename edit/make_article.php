<!DOCTYPE html>

<html>
<title>記事一覧</title>
<meta charset="UTF-8");
<meta name="viewport", content="width=device-width, initial-scale=1.0">
<PRE>
<?php
 
    require_once("../db_access.php");
    $db = new blog_db();
    
    if($db->make_article($_POST["title"], $_POST["content"], $_POST["detail"])){
        echo"投稿成功";
    }else{
        echo "投稿失敗";
    }
?>
</PRE>
</html>
