<?php
/**
 * Created by PhpStorm.
 * User: volko
 * Date: 22.08.2019
 * Time: 15:17
 */

require_once "vendor/autoload.php";
use Src\Database\Server;
use Queue\QueueDB;

$server = Server::Init('queue_sys');
$queue1 = new QueueDB("queue10", $server->connection);
echo "1. I'm work!\n";
for($i = 1; $i <= 10; $i++){
    $queue1->pop()->handle();
    sleep(1);
}
