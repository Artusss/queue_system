<?php
/**
 * Created by PhpStorm.
 * User: volko
 * Date: 21.08.2019
 * Time: 13:16
 */

namespace Src\Database;

class Server extends Singleton //класс соединения с бд
{
    protected static $db_name; //имя базы данных
    protected static $host; //имя хоста
    protected static $user_name; //пользователь
    protected static $password; //пароль
    protected static $charset; //кодировка
    protected static $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ]; //параметры по умолчанию

    public $connection; //хранит соединение с БД

    protected function __construct() { //вызывается методом Init()
        $host = self::$host;
        $db_name = self::$db_name;
        $charset = self::$charset;
        $dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
        $options = self::$options;
        $this->connection = new \PDO($dsn, self::$user_name, self::$password, $options); //Производит соединение с БД
    }

    //создает единственный обЪект класса Server или его дочерних классов
    public static function Init($db_name, $host = '192.168.10.10', $user_name = 'homestead', $password = 'secret', $charset = 'utf8'){
        self::$host = $host;
        self::$user_name = $user_name;
        self::$password = $password;
        self::$db_name = $db_name;
        self::$charset = $charset;
        if(is_null(self::$_instance)){
            self::$_instance = new self; //Если отсутствует экземпляр класса, создаем его
        }
        return self::$_instance; //Возвращаем единственный экземпляр класса
    }
}