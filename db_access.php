<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db_access
 *
 * @author TAKUMI
 */
class db_access {
    //put your code here
    //DBに接続
    private $db_user = "ns";
    private $db_pass = "ns8931";
    private $db_host = "localhost";
    private $db_name = "blog_db";
    private $db_type = "mysql";
    public $pdo;
    
    public function db_access(){
        $dsn = "$this->db_type:host=$this->db_host;dbname=$this->db_name;charset=utf8";
        try{
            $this->pdo = new PDO($dsn, $this->db_user, $this->db_pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (Exception $ex) {
            die('エラー:' . $ex->getMessage());
        }
    }
}


class blog_db extends db_access{
    public function blog_db(){
        $this->db_access();
    }
    
    
    public function read_contents(){
        $sql = "select * from archive order by created desc limit 0, 5";
        try{
            $stmh = $this->pdo->prepare($sql);
            $stmh->execute();
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                print('<article class="thumbnail">');
                print('<h1 class="article_title"><a href="/Blog/Blog_article.php/');
                print($row["id"] .'">' . $row["title"] .'</a></h1>');
                print('<div class="article_detail">');
                print($row["content"]);
                print("</div>");
                print('<hr><div class="article_footer">');
                print($row["created"]);
                print(' </div>
                        <hr>');
                print('</article>');
            }
        } catch (Exception $ex) {
            die('エラー:'. $ex->getMessage());
            return false;
        }
    }
    
    public function read_detail($id){
        $sql = "select * from archive where id = $id";
        try{
            $stmh = $this->pdo->prepare($sql);
            $stmh->execute();
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                if($row["id"] == $id){
                print('<article class="thumbnail">');
		print('<h1 class="article_title">');
                print($row["title"] .'</h1>');
		print('<div class="article_detail">');
                print($row["content"] . "<br>");
                print($row["detail"] . "<br>");
                print("</div>");
                print('<hr><div class="article_footer">');
                print($row["created"]);
                print(' </div>
                        <hr>');
                print('</article>');
                }
            }
        } catch (Exception $ex) {
            die('エラー:'. $ex->getMessage());
            return false;
        }
    }
    
    public function write_blog($id, $title, $content, $detail){
        $title = $this->pdo->quote($title);
        $content = $this->pdo->quote($content);
        $detail = $this->pdo->quote($detail);
        $sql = "update archive set
                content = $content, 
                title = $title,
                detail = $detail
                where id = $id;";
        //echo("<PRE>" . $sql . "</PRE>");
        try{
            $stmh = $this->pdo->prepare($sql);
            $stmh->execute();
            return true;
        } catch (Exception $ex) {
            die('エラー:' . $ex->getMessage());
            return false;
        }
    }
    
    public function make_article($title, $content, $detail){
        $title = $this->pdo->quote($title);
        $content = $this->pdo->quote($content);
        $detail = $this->pdo->quote($detail);
        $date = date('Y-m-d H:i:s');
        $date = $this->pdo->quote($date);
        echo $date;
        $sql = "insert into archive(title, content, detail, created) value(
                $title, $content, $detail, $date);";
        try{
            $stmh = $this->pdo->prepare($sql);
            $stmh->execute();
            return true;
        } catch (Exception $ex) {
            die('エラー:' . $ex->getMessage());
            return false;
        }
    }
    
    public function delete_article($blog_id){
        $sql = "delete from archive where id = $blog_id";
        
        try{
            $stmh = $this->pdo->prepare($sql);
            $stmh->execute();
            return true;
        }catch (Exception $ex) {
            die('エラー:' . $ex->getMessage());
            return false;
        }        
    }
}

class comment_db extends db_access{
    public function comment_db(){
        $this->db_access();
    }
    
    public function read_comment($blog_post_id){
        $sql = "select name, message, created from comment where blog_post_id = $blog_post_id order by id";
        try{
            $stmh = $this->pdo->prepare($sql);
            $stmh->execute();
            echo ("<ul>");
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                echo("<li><div class=\"entry\"><h3>" . $row["name"] . "</h3>\n");
                echo("<p>\n");
		$message = $row["message"];
		$message = nl2br($message);
                echo($message);
                echo("</p>\n");
                echo("</div></h3></li>\n");
            }
            echo ("</ul>");
            return true;
        } catch (Exception $ex) {
            die('エラー:'. $ex->getMessage());
            return false;
        }
    }
    

    //データベース登録の際にはタグをすべてエスケープする
    public function write_comment($blog_post_id, $name, $message){
        $message = htmlspecialchars($message);
	$message = $this->pdo->quote($message);
        $name = $this->pdo->quote($name);
        $sql = "insert into comment(blog_post_id , name, message)
                value($blog_post_id, $name, $message);";
        try{
            $stmh = $this->pdo->prepare($sql);
            $stmh->execute();
            return true;
        } catch (Exception $ex) {
            die('エラー:'. $ex->getMessage());
            return false;
        }
    }
}

?>

