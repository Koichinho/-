 <?php
    $dsn = 'mysql:dbname=tb230350db;host=localhost';
    $user = 'tb-230350';
    $password = '5kMuGP65HN';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //$rowの添字（[ ]内）は、4-2で作成したカラムの名称に併せる必要があります。
    $sql = 'SELECT * FROM tblogin';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['password'].',';
        echo $row['mail'].',';
        echo $row['datetime'].'<br>';
    echo "<hr>";
    }
    
    ?>