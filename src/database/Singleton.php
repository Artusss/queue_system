<?php
/**
 * Created by PhpStorm.
 * User: volko
 * Date: 21.08.2019
 * Time: 13:22
 */

namespace Src\Database;


class Singleton //родительский класс для соединения с бд (см. шаблон Singleton)
{
    protected static $_instance = null; //хранит экземпляр дочернего класса
    protected function __clone() {}
    protected function __wakeup() {}
}