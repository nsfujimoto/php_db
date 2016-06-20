<!DOCTYPE html>

<html>
<title>記事一覧</title>
<meta charset="UTF-8");
<meta name="viewport", content="width=device-width, initial-scale=1.0">

<?php
    ini_set("display_errors", 1);
    require_once '../db_access.php';
?>

<?php
    if(isset($_GET["id"])){
    $id = $_GET["id"];
    $db = new blog_db();
    $sql = "select title, content, detail from archive where id = $id";
    $stmh = $db->pdo->prepare($sql);
    $stmh->execute();
    $row = $stmh->fetch(PDO::FETCH_ASSOC);
?>
<html>
    <head>
        <title><?=$row["title"] ?></title>
    </head>
    <body>
        <form method="post" action="write_db.php" name="form1" >
            Title:<br>
            <input type="text" name="title" value="<?=$row["title"]?>" style="width:500"><br><br>
            Content:<br>
            <textarea style="width: 800px; height:200px" name="content"><?php
                print($row["content"]);
            ?></textarea>
            <br><br>
            Detail:<br>
            <textarea style="width: 800px; height:500px" name="detail"><?php
                print($row["detail"]);
                ?></textarea><br><br>
            <input type="submit" value="送信">
            <input type="hidden" name="id" value="<?=$_GET["id"]?>">
        </form>
    </body>
</html>

<?php
    }else{
        ?>

<html>
    <head>
        <title></title>
    </head>
    <body>
        <form method="post" action="make_article.php" name="form1" >
            Title:<br>
            <input type="text" name="title" style="width:500"><br><br>
            Content:<br>
            <textarea style="width: 800px; height:200px" name="content"></textarea>
            <br><br>
            Detail:<br>
            <textarea style="width: 800px; height:500px" name="detail"></textarea><br><br>
            <input type="submit" value="送信">
        </form>
    </body>
</html>


<?php
        
    echo(date("Y-m-d H:i:s"));    
    }

?>

</html>