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
$queue2 = new QueueDB("queue20", $server->connection);
echo "2. I'm work!\n";
for($i = 1; $i <= 10; $i++){
    $queue2->pop()->handle()."\n";
    sleep(3);
}