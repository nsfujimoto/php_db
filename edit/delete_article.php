<html>
<title>記事一覧</title>
<meta charset="UTF-8");
<meta name="viewport", content="width=device-width, initial-scale=1.0">
<?php

    require_once"../db_access.php";
    $db = new blog_db();
    if(isset($_GET["id"])){
        if($db->delete_article($_GET["id"])){
            echo"削除成功";
        }else{
            echo"削除失敗";
        }
    }else{
        echo"削除失敗";
    }
    
?>
</html>
