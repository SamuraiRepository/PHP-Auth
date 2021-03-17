<?php

# PDO使用に必要な共通処理を get_pdo.php に定義しなした。
include('./get_pdo.php');

function create_user($username, $password) {
    # パスワードを安全に扱うためには下記のようにパスワードを暗号化します。
    # スラスラPHPに記載されているコードは現在セキュリティーの不安があるため、このコードを使ってください。
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        # get_pdo.php ファイルに定義されている関数を使って PDO インスタンスを生成します。
        $db = get_pdo();

        # ユーザーを追加するためのSQL文を用意します。
        $stmt = $db->prepare('
            INSERT INTO tmp_users(username, password) 
            VALUES (:username, :password)
        ');

        # username, password に値をバインドします。
        # password をバインドする時には $hashed_password を使っていることに注意してください。
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        
        # SQL文を実行します。
        $result = $stmt->execute();

        # SQL文に何かの問題があり、実行に失敗した時のエラー処理です。
        if (!$result) {
            throw new Exception('ユーザー追加に失敗しました。');
        }

        # ユーザー追加成功後、アプリを終了します。
        echo 'ユーザー追加に成功しました。';
        exit();
    } catch (PDOException $e) {
        echo 'エラー：' . $e->getMessage();
        die();
    } catch (Exception $e) {
        echo 'エラー：' . $e->getMessage();
        die();
    }
    
}

# 関数実行
create_user('kim', '1234');