<?php

session_start();

// 関数を呼び出す
require_once('funcs.php');
loginCheck();

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();
$stmt = $pdo->prepare("SELECT * FROM book_table");

// SQL実行
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    exit('SQLError:' . $e->getMessage());
}

// 結果表示
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>データ一覧</title>
</head>
<body>
<header></header>
<form class="logout-form" action="logout.php" method="post" onsubmit="return confirm('本当にログアウトしますか？');">
            <button type="submit" class="logout-button">ログアウト</button>
        </form>
    <h1>データ一覧</h1>
    <?php while ($result = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <p>
            <?= htmlspecialchars($result['created_at'], ENT_QUOTES, 'UTF-8') ?> : 
            <a href="<?= htmlspecialchars($result['img'], ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8')?>
            </a>
            <?= htmlspecialchars($result['content'], ENT_QUOTES, 'UTF-8') ?>
            <a href="detail.php?book_id=<?= htmlspecialchars($result['book_id'], ENT_QUOTES, 'UTF-8')?>">編集はこちら
            <form method="POST" action="delete.php">
                <input type="hidden" name="book_id" value="<?= htmlspecialchars($result['book_id'], ENT_QUOTES, 'UTF-8') ?>">
                <input type="submit" value="削除">
            </form>
        </p>
    <?php endwhile; ?>
</body>
</html>
