<?php
class Cfg
{

    private static $dbConnect = null;

    /**
     * PDO-соединение реализовано, как синглтон
     * @return null|PDO
     */
    static function getDB()
    {
        if (null === self::$dbConnect){
            self::$dbConnect = new PDO("mysql:host=localhost;dbname=test;charset=UTF8", "test_user", "111");
        }

        return self::$dbConnect;
    }

}
