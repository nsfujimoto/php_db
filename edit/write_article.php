<!DOCTYPE html>

<html>
<head>
<title>記事一覧</title>
<meta charset="UTF-8");
<meta name="viewport", content="width=device-width, initial-scale=1.0">
<script src="/marked/lib/marked.js"></script>
<script src="/Blog/Blog_config/my.js"></script>
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
        <title><?=$row["title"] ?></title>
    </head>
    <body onload="enable_tab('input_field')">
    <table>
        <tr><td>
        <form method="post" action="write_db.php" name="form1" >
            Title:<br>
            <input type="text" name="title" value="<?=$row["title"]?>" style="width:500"><br><br>
            Content:<br>
            <textarea style="width: 800px; height:200px" oninput="change_txtarea();"
                name="content" class="input_field" id="content"><?php
                print($row["content"]);
            ?></textarea>
            <br><br>
            Detail:<br>
            <textarea style="width: 800px; height:500px" oninput="change_txtarea();"
                name="detail" class="input_field" id="detail"><?php
                print($row["detail"]);
                ?></textarea><br><br>
            <input type="submit" value="送信">
            <input type="hidden" name="id" value="<?=$_GET["id"]?>">
        </form>
        </td></tr>
        <tr><td style="border: dashed 1px; padding: 5px;">
            <div id="prev_field">aaaa</div>
        </td></tr>
    </table>
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


<?php
        
    echo(date("Y-m-d H:i:s"));    
    }

?>

</html>
