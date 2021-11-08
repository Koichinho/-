<?php

    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql1 = "CREATE TABLE IF NOT EXISTS tblogin"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "password TEXT,"
    . "mail TEXT,"
    . "datetime TEXT"
    .");";
    $stmt = $pdo->query($sql1);    
    
    $sql2 = "CREATE TABLE IF NOT EXISTS tbpost"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "password TEXT,"
    . "message TEXT,"
    . "image MEDIUMBLOB,"
    . "datetime TEXT"
    .");";
    $stmt = $pdo->query($sql2);
    
    
    if(!empty($_POST["name1"])&&!empty($_POST["password1"])&&!empty($_POST["email"])){//新規
        $name1 = $_POST["name1"];
        $password1 = $_POST["password1"];
        $email = $_POST["email"];
        
    }
    
    if(!empty($_POST["name2"])&&!empty($_POST["password2"])){//ログイン
        $name2 = $_POST["name2"];
        $password2 = $_POST["password2"];
        
    }
    
    if(empty($_FILES["image"]["name"])){//投稿（写真なし）
       if(empty($_POST["name3"])&&empty($_POST["password3"])&&!empty($_POST["message"])){
           $name3 = $_POST["name3"];
           $password3 = $_POST["password3"];
           $message = $_POST["message"];
           
       }
       else if(!empty($_POST["name3"])&&!empty($_POST["password3"])&&!empty($_POST["message"])){
           $name3 = $_POST["name3"];
           $password3 = $_POST["password3"];
           $message = $_POST["message"];
               
        }
        
    }
    
    else{//投稿（写真あり）
        if(empty($_POST["name3"])&&empty($_POST["password3"])&&!empty($_POST["message"])){
           $name3 = $_POST["name3"];
           $password3 = $_POST["password3"];
           $message = $_POST["message"];
           
       }   
        else if(!empty($_POST["name3"])&&!empty($_POST["password3"])&&!empty($_POST["message"])){
           $name3 = $_POST["name3"];
           $password3 = $_POST["password3"];
           $message = $_POST["message"];
           $imagename = $_FILES["image"]["name"];
           $imagesize = $_FILES["image"]["size"];
           $image = file_get_contents($_FILES['image']['tmp_name']);
            
        }
        
    }
    
    if(!empty($_POST["name4"])){//検索
        $name4 = $_POST["name4"];
    }
    
    $datetime = date("Y/m/d H:i:s");
        
?>



<div style="background-color: pink">
<h2 style="text-align:center"><span style="font-size: 50px;">ぽかぽか事件簿</span></h2><br>
<span style="font-size: 20px;">
ぽかぽか事件簿とは「優しさ」をテーマに日常にある些細な幸せや、嬉しかったことを<br>
多くの人と共有してみんなでハッピーになろうという掲示板です。<br>
ここでは暴言や誹謗中傷は禁止です。<br>
写真も一緒に投稿して多くの人に見てもらいましょう！！<br>
<div style="background-color:gold">
ルール
<ul>
    <li>他人を傷つけたり、見る人が不快になるようなことを書き込まない。</li>
    <li>個人情報などプライバシーにかかわることは書き込まない。</li>
    <li>優しさをもって投稿しよう！</li>
</ul>
</div>
みんなでルールを守って幸せな気持ちになっちゃいましょう！！<br><br></span>
 <!DOCTYPE html>
<html lang="ja">
   <head>
   <meta charset ="uft-8">
   <title>ぽかぽか事件簿.php</title>
   </head>
   <body>
        <form action="" method="post">
        ユーザー登録:初めて書き込む人はこちらからユーザー情報を登録してね。<br>
        <input type="text" name="name1" required placeholder="ユーザー名"><br>
        <input type="text" name="password1" required placeholder="パスワード"><br>
        <input type="email" id="email" name="email"　pattern=".+@globex\.com" size="30" required placeholder="メールアドレス"><br>
        <input type="submit" name="submit"><br><br>
        </form>
       
        ログイン:以前ユーザー登録した人はこちらから！<br>
        <form action="" method="post">
        <input type="text" name="name2" required placeholder="ユーザー名"><br>
        <input type="text" name="password2" required placeholder="パスワード"><br>
        <input type="submit" name="submit"><br><br>
        </form>
        
        投稿:いっぱい優しさを書き込んでね！
        <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="name3" placeholder="ユーザー名" value="<?php echo ""; if(!empty($name2)&&!empty($password2)){$sql = 'SELECT * FROM tblogin';$stmt = $pdo->query($sql);$results = $stmt->fetchAll();foreach ($results as $row){if($row["name"]==$name2){if($row["password"]==$password2){echo $name2;}else{echo "";}}}}?>" readonly>
        <input type="hidden" name="password3" placeholder="パスワード" value="<?php echo ""; if(!empty($name2)&&!empty($password2)){$sql = 'SELECT * FROM tblogin';$stmt = $pdo->query($sql);$results = $stmt->fetchAll();foreach ($results as $row){if($row["name"]==$name2){if($row["password"]==$password2){echo $password2;}else{echo "";}}}}?>" readonly><br>
        <textarea id="t_message" name="message" required cols="30" rows="5" placeholder="出会った幸せを書き込もう！"></textarea><br>
        画像を一緒に共有しよう！<br>
        <input type="file"name="image" accept="image/png, image/jpeg" ><br>
        <input type="submit" name="submit">
        </form>
        
        検索:ユーザー名で検索できます。<br>
        <form action="" method="post">
        <input type="text" name="name4" required placeholder="ユーザー名"><br>
        <input type="submit" name="submit"><br><br>
        </form>
        <?php
        
        if(!empty($name1)&&!empty($password1)&&!empty($email)){//新規登録コード
            
            $n = 1;//新規登録者か、以前に登録したことがある人か、既に存在する名前で登録する場合  
            $sql = 'SELECT * FROM tblogin';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            if($row['name']==$name1&&$row['mail']==$email){//新規登録者か間違えてまた登録しようとしたかを判断
                echo '<span style="color:orangered;">このユーザー名で既に登録されています。</span>';
                echo "<br>";
                echo '<span style="color:orangered;">ログインしてください。</span>';
                echo "<br><br>";
                $n=0;
                        
            }
            
            else if($row['name']==$name1&&$row['mail']!=$email){
                echo '<span style="color:orangered;">このユーザー名は既に使用されています。</span>';
                echo "<br>";
                echo '<span style="color:orangered;">違うユーザー名で登録してください。</span>';
                echo "<br><br>";
                $n=0;
                        
            }
                
            }
                
            if($n>0){
               echo '<span style="color:forestgreen;">ユーザー登録成功です。</span>';
                echo "<br>";
                echo '<span style="color:forestgreen;">ログインして投稿しよう！</span>';
                echo "<br><br>";
                $sql = $pdo -> prepare("INSERT INTO tblogin (name, password, mail, datetime) VALUES (:name, :password, :mail, :datetime)");
                $sql -> bindParam(':name', $name1, PDO::PARAM_STR);
                $sql -> bindParam(':password', $password1, PDO::PARAM_STR);
                $sql -> bindParam(':mail', $email, PDO::PARAM_STR);
                $sql -> bindParam(':datetime', $datetime, PDO::PARAM_STR);
                $sql -> execute();
                
                require 'src/Exception.php';
                require 'src/PHPMailer.php';
                require 'src/SMTP.php';
                require 'settingmail.php';
                
                // PHPMailerのインスタンス生成
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP(); // SMTPを使うようにメーラーを設定する
                $mail->SMTPAuth = true;
                $mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
                $mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
                $mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
                $mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
                $mail->Port = SMTP_PORT; // 接続するTCPポート
                
                // メール内容設定
                $mail->CharSet = "UTF-8";
                $mail->Encoding = "base64";
                $mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
                $mail->addAddress($email, $name1); //受信者（送信先）を追加する
                //    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');
                //    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加
                //    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加
                $mail->Subject = MAIL_SUBJECT; // メールタイトル
                $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
                $body = 'この度はぽかぽか事件簿へご登録いただきありがとうございます。<br>登録完了いたしました！<br>ぜひログインしていただき'.$name1."さんが出会ったやさしさ幸せを多くの人に届けてください。";
                
                $mail->Body  = $body; // メール本文
                // メール送信の実行
                if(!$mail->send()) {
                    echo 'メッセージは送られませんでした！';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    
                } else {
                    echo '送信完了！';
                    
                }
                
            }
        
            $sql = 'SELECT * FROM tbpost';//投稿内容表示
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['datetime'].','."<br>";
                if(!empty($row["image"])){
                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>'."<br>";
                    
                }
                echo $row['message'].'<br>';
                echo "<hr>";
                
            }
            
        }
        
        if(!empty($name2)&&!empty($password2)){//ログインコード
            $a=0;
            $b=0;
            $c=0;
            $sql = 'SELECT * FROM tblogin';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                if($row["name"]==$name2&&$row["password"]==$password2){
                    $a=1;
                        
                    }
                else if($row["name"]==$name2&&$row["password"]!=$password2){
                    $b=1;
                        
                    }
                else if($row["name"]!=$name2){
                    $c=1;
                    
                }
                
            }
            if($a==1){
                echo '<span style="color:forestgreen;">ログイン成功です。</span>';
                echo "<br>";
                echo '<span style="color:forestgreen;">出会った幸せを投稿してください！！</span>';
                echo "<br><br>";
            }
            if($b==1){
                echo '<span style="color:orangered;">パスワードが間違っています。</span>';
                echo "<br><br>";
            }
            if($a==0&&$b==0&&$c==1){
                echo '<span style="color:orangered;">入力されたユーザー名は登録されていません。</span>';
                echo "<br><br>";
            }
            
            $sql = 'SELECT * FROM tbpost';//投稿内容表示
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['datetime'].','."<br>";
                if(!empty($row["image"])){
                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>'."<br>";
                    
                }
                echo $row['message'].'<br>';
                echo "<hr>";
                
            }
            
        }
        
        if(empty($name3)&&empty($password3)&&!empty($message)&&empty($imagename)){//ログインできていないのに投稿してしまうとき
            echo '<span style="color:orangered;">ログインしていない状態で投稿しています。</span>';
            echo "<br>";
            echo '<span style="color:orangered;">ログインしてから投稿してください。</span>';
            echo "<br><br>";
        }
        
        else if(empty($name3)&&empty($password3)&&!empty($message)&&!empty($imagename)){//ログインできていないのに投稿してしまうとき
            echo '<span style="color:orangered;">ログインしていない状態で投稿しています。</span>';
            echo "<br>";
            echo '<span style="color:orangered;">ログインしてから投稿してください。</span>';
            echo "<br><br>";
        }
        
        else if(!empty($name3)&&!empty($password3)&&!empty($message)&&empty($imagename)){//投稿コード(画像なし)
            echo '<span style="color:forestgreen;">無事投稿できました。</span>';
            echo "<br>";
            echo '<span style="color:forestgreen;">みんなにやさしさを共有してくれてありがとう！</span>';
            echo "<br><br>";
            
            $sql = $pdo -> prepare("INSERT INTO tbpost (name, password, message, datetime) VALUES (:name, :password, :message, :datetime)");
            $sql -> bindParam(':name', $name3, PDO::PARAM_STR);
            $sql -> bindParam(':password', $password3, PDO::PARAM_STR);
            $sql -> bindParam(':message', $message, PDO::PARAM_STR);
            $sql -> bindParam(':datetime', $datetime, PDO::PARAM_STR);
            $sql -> execute();
            
            $sql = 'SELECT * FROM tbpost';//投稿内容表示
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['datetime'].','."<br>";
                if(!empty($row["image"])){
                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>'."<br>";
                    
                }
                echo $row['message'].'<br>';
                echo "<hr>";
                
            }
            
        }
        

        
        else if(!empty($name3)&&!empty($password3)&&!empty($message)&&!empty($imagename)){//投稿コード（画像あり）
            echo '<span style="color:forestgreen;">無事投稿できました。</span>';
            echo "<br>";
            echo '<span style="color:forestgreen;">みんなにやさしさを共有してくれてありがとう！</span>';
            echo "<br><br>";
            
            $sql = $pdo -> prepare("INSERT INTO tbpost (name, password, message, image, datetime) VALUES (:name, :password, :message, :image, :datetime)");
            $sql -> bindParam(':name', $name3, PDO::PARAM_STR);
            $sql -> bindParam(':password', $password3, PDO::PARAM_STR);
            $sql -> bindParam(':message', $message, PDO::PARAM_STR);
            $sql -> bindParam(':image', $image, PDO::PARAM_STR);
            $sql -> bindParam(':datetime', $datetime, PDO::PARAM_STR);
            $sql -> execute();
            
            $sql = 'SELECT * FROM tbpost';//投稿内容表示
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['datetime'].','."<br>";
                if(!empty($row["image"])){
                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>'."<br>";
                    
                }
                echo $row['message'].'<br>';
                echo "<hr>";
                
            }
            
        }
        
        if(!empty($name4)){
            $unknown=0;
            $sql = 'SELECT * FROM tbpost';//検索内容表示
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                if($row["name"]==$name4){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['datetime'].','."<br>";
                    if(!empty($row["image"])){
                        echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>'."<br>";
                        
                    }
                    echo $row['message'].'<br>';
                    echo "<hr>";
                    $unknown = 1;
                }
                
            }
            if($unknown==0){
                echo $name4."さんは投稿されていません。<br>";
            }
        }
    ?>
    
   </body>
</html>
</div>
