<?php
    $dsn = 'mysql:dbname=tb230350db;host=localhost';
    $user = 'tb-230350';
    $password = '5kMuGP65HN';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql = 'SELECT * FROM tbpost';
    $stmt = $pdo->query($sql);
    $result1 = $stmt->fetchAll();
    //パラメータをセット
    $id=1;
    $result1->bindparam(1,$id,PDO::PARAM_INT);
    $result1->execute();
    $row = $result1 -> fetch(PDO::FETCH_ASSOC);
    //取得した画像バイナリデータをbase64で変換。
    $img = base64_encode($row['image']);
 ?>
    <!-- エンコードした情報をimgタグに表示 -->
    <img src="data:<?php echo $row['ext'] ?>;base64,<?php echo $img; ?>"><br>