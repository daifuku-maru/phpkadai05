<?php

/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */


 session_start();

 // 関数を呼び出す
require_once('funcs.php');
loginCheck();

require_once('funcs.php');
$pdo = db_conn();


$id = $_GET['id'];
 
//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM bok_table WHERE id=:id;');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();
 
 //３．データ表示
 $view = '';
 if ($status === false) {
     $error = $stmt->errorInfo();
     exit('SQLError:' . print_r($error, true));
 }


?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<!-- Head[Start] -->
	<header>
	  <nav>
	    <a href="select.php">データ一覧</a>
	  </nav>
	</header>
	<!-- Head[End] -->
	
	<!-- method, action, 各inputのnameを確認してください。  -->
	<form method="POST" action="update.php">
	  <fieldset>     
	  <main>
        <form method="POST" action="insert.php" enctype="multipart/form-data">
            <fieldset>
                <legend>ブックマーク</legend>
                <label for="name">作品名</label>
                <input type="text" id="name" name="name" required placeholder="ONE PIECE">

                <label for="url">作品データ</label>
                <input type="file" id="image" name="image">

                <label for="content">コメント</label>
                <textarea id="content" name="content" rows="4" placeholder="作品説明など"></textarea>

                <input type="submit" value="送信する">
            </fieldset>
        </form>
    </main>
</body>
</html>