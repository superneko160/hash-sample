<?php
/**
 * 設定情報を管理するのみのクラス
 */
class CodeInfo {

    // DB設定（開発用）
    private const DSN = 'mysql:dbname=selfphp; host=localhost; charset=utf8';
    private const DB_USER = 'root';
    private const DB_PASSWORD = '';

    /**
     * DB設定の取得
     * @return array $codes DB設定情報
     */
    public static function getCodes(): array {
        $codes = [];
        $codes['dns'] = self::DSN;
        $codes['db_user'] = self::DB_USER;
        $codes['db_password'] = self::DB_PASSWORD;
        return $codes;
    }
}