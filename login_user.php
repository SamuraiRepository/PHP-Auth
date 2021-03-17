<?php

# PDO使用に必要な共通処理を get_pdo.php に定義しなした。
include('./get_pdo.php');

function login($username, $password) {
    try {
        # get_pdo.php ファイルに定義されている関数を使って PDO インスタンスを生成します。
        $db = get_pdo();

        # ログイン処理をするためにユーザー情報をDBから取得します。
        # パスワードは暗号化されているため、usernameを条件としてユーザーを取得していることに注意してください。
        # スラスラPHPに記載されているコードは現在セキュリティーの不安があるため、このコードを使ってください。
        $stmt = $db->prepare('
            SELECT * 
            FROM tmp_users 
            WHERE username=:username
            LIMIT 1
        ');

        # username に値をバインドします。
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        
        # SQL文を実行します。
        $result = $stmt->execute();

        # SQL文に何かの問題があり、実行に失敗した時のエラー処理です。
        if (!$result) {
            throw new Exception('ログインに失敗しました。');
        }

        # SQL実行結果を取得します。
        # $stmt->fetch() を使って、1つの結果を取得することができます。
        # 今回実行したSQL文はLIMIT 1の条件をつけましたので、結果が1つであることが事前にわかります。
        $user = $stmt->fetch();

        # パスワードのチェックはPHPが用意している password_verify 関数を使って行ってください。
        $password_check = password_verify($password, $user['password']);

        # パスワードのチェックが失敗したのはパスワードに誤りがあることを意味します。
        if (!$password_check) {
            throw new Exception('パスワードを再確認してください。');
        }

        # ユーザーログインに成功後、アプリを終了します。
        # スラスラPHPを参考にし、ユーザー情報をセッションに保存するなど処理を加えてください。
        echo 'ログインに成功しました。';
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
login('kim', '1234');