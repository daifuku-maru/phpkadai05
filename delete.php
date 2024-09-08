<?php  
    $id = $_POST['id'];
    try{
        $db_name = 'book-card_ty_gsmil';
        $db_id='book-card';
        $db_pw='tatsuya1998';
        $db_host='mysql660.db.sakura.ne.jp';
        $pdo= new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
    }catch(PDOException $e){
        exit('DB Connectokn Error:' . $e->getMessage());
    }

    $stmt = $pdo->prepare('DELETE FROM phpkadai02 WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $status = $stmt->execute();

    if($status === false){
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    }else{
        header('Location: select.php');
        exit();
    }
?>