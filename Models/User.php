<?php
declare(strict_types=1);

require_once 'utils/Database.php';

/**
 * Userクラス
 * DBのusersテーブルに対しての処理を担う
 */
class User {

    private $db = null;  // DB
    private $table = 'users';  // テーブル名

    /**
     * コンストラクタ
     */
    function __construct() {
        // DB接続
        $this->db = Database::getDb();
    }

    /**
     * ユーザ新規登録
     * 同一ユーザ名が存在した場合の判定など実装していないので注意
     * 
     * @param string $name ユーザ名
     * @param string $password パスワード（暗号化前）
     * @return string|false 登録したユーザのID
     */
    public function create(string $name, string $password): string {
        try {
            $sql = "INSERT INTO {$this->table}(name, password) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, password_hash($password, PASSWORD_DEFAULT));  // パスワードはバインド時に暗号化
            $stmt->execute();
            // 登録に成功した場合、たった今登録したユーザのIDを返す
            return $this->db->lastInsertId();
        }
        catch (Exception $e) {
            throw new Exception("エラーメッセージ:{$e->getMessage()}");
        }
    }

    /**
     * ユーザ名からユーザ取得
     * 
     * @param string $name ユーザ名
     * @param array $user ユーザ情報
     */
    public function getUserByName(string $name): array {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE name = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(1, $name);
            $stmt->execute();
            $users = [];
            while ($user= $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $user;
            }
            // 同一ユーザ名が登録できない設定だとして、今回はインデックス0のデータを返す
            // （最初に取得したユーザを返す）
            return $users[0];
        }
        catch (Exception $e) {
            throw new Exception("エラーメッセージ:{$e->getMessage()}");
        }
    }
}