<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

$name = $_POST['name'];
$url = $_POST['url'];
$content = $_POST['content'];
$id = $_POST['id'];

try{
    $db_name = 'phpkadai04';
    $db_id='root';
    $db_pw='';
    $db_host='localhost';
    $pdo = new PDO('mysql:dbname='. $db_name . ';charset=utf8;host='. $db_host, $db_id, $db_pw);
}catch(PDOException $e){
    exit('DBConnetError:' . $e->getMessage());
}

//3. データ更新SQL作成
$stmt = $pdo->prepare('UPDATE phpkadai02 SET book_name = :name, book_url=:url, book_comment = :content, date = sysdate() WHERE id = :id;');

// バインド変数を設定
$stmt->bindValue(':name', $name, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':url', $url, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':content', $content, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':id', $id, PDO::PARAM_INT);// 数値の場合 PDO::PARAM_INT

//4. データ登録処理後
$status = $stmt->execute();// 実行

if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit();
}

?>