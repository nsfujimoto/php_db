<?php
    require_once 'db_access.php';

    class album_db extends db_access {
        function album_db(){
            $this->db_access();
        }

        function exec_sql($sql){
            try{
            $stmh = $this->pdo->prepare($sql);
            $stmh->execute();
            return $stmh;
            }catch(Exception $ex){
                die("エラー:" . $ex->getMessage());
            }
        }

        function add_photos($photo_url, $photo_name){
            $url = $this->pdo->quote($photo_url);
            $name = $this->pdo->quote($photo_name);
            $date = $this->pdo->quote(date("Y-m-d H:i:s"));
            if($this->check_unique_url($photo_url)){
                $sql = "insert into album(url, name, date) 
                        value($url, $name, $date)";
                try{
                    $stmh = $this->pdo->prepare($sql);
                    $stmh->execute();
                    return true;
                }catch(Exception $ex){
                    die("エラー:". $ex->getMessage());
                    return false;
                }
            }else{
                throw new Exception("同一名のファイルがあります");
            }
        }

        function delete_photos_url($photo_url){
            $url = $this->pdo->quote($photo_url);
            $this->exec_sql("delete from album where url = $url");
        }

        function check_unique_url($photo_url){
            $url = $this->pdo->quote($photo_url);
            $stmh = $this->exec_sql("select count(*) from album where url = $url");
            $cnt;
            foreach($stmh as $value) $cnt = $value["count(*)"];
            if($cnt == 0)return true;
            else return false;
        }

        function get_photos($page){
            $min = 20*$page;
            $max = $min + 20;
            $sql = "select * from album limit $min, $max ";
            return $this->exec_sql($sql);
        }

        function count_photos(){
            $sql = "select count(*) from album";
            $stmh = $this->exec_sql($sql);
            foreach($stmh as $value){
                return (int)$value["count(*)"];
            }
            return 0;
        }

        function delete_photo_from_id($id){
            $photo_id = (int)$id;
            $sql = "delete from album where id = $photo_id";
            $stmh = $this->exec_sql($sql);
        }

        function get_photo_from_id($id){
            $photo_id = (int)$id;
            $sql = "select * from album where id = $photo_id";
            return $this->exec_sql($sql);
        }
    }
?>