<?php
session_start();

require_once('funcs.php');
$pdo = db_conn();

// フォームデータの取得
$title = $_POST['name'];
$img = $_FILES['image'];
$content = $_POST['content'];

// 画像パスを保存する用の変数を用意。空っぽにするのは、保存失敗時にもプログラムが動くようにするため
$image_path = '';

// そもそもファイルデータがない場合は画像保存に関する一連の処理は不要なのでif文を使う 
if (isset($_FILES['image'])) {

	// imageの部分はinput type="file"のname属性に相当します。
	// 必要に応じて書き換えるべき場所です。
	$upload_file = $_FILES['image']['tmp_name'];
	
	//画像の拡張子を取得
	$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	
	// 画像名を取得。今回はuniqid()をつかって　保存時の時刻情報をファイル名とする
	$file_name = uniqid() . '.' . $extension;
	
	// フォルダ名を取得。今回は直書き。
	$dir_name = 'img/';
	
	// image_pathを確認
	$image_path = $dir_name . $file_name;
	
  if (!move_uploaded_file($upload_file, $image_path)) {
     exit('ファイルの移動に失敗しました。');
  }
}

// SQL文を準備
$stmt = $pdo->prepare("INSERT INTO book_table(title, img, content, created_at) VALUES(:title, :img, :content, NOW())");

// バインド変数を設定
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':img', $image_path, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);

// SQL実行
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    exit('SQLError:' . $e->getMessage());
}

// 実行結果の確認
if($status === false){
    $error = $stmt->errorInfo();
    exit("ErrorMessage:" . $error[2]);
} else {
    header("Location: index.php");
    exit();
}
?>
