<?php
/**
 * Created by PhpStorm.
 * User: volko
 * Date: 22.08.2019
 * Time: 19:41
 */

require_once "vendor/autoload.php";
use Src\Database\Server;
use Src\Job;
use Queue\QueueDB;

$server = Server::Init('queue_sys');
$queue1 = new QueueDB("queue10", $server->connection);
$queue2 = new QueueDB("queue20", $server->connection);

for($i = 1; $i <= 10; $i++){
    $queue1->push(new Job("job_".$i, "data_".$i));
}
for($i = 11; $i <= 20; $i++){
    $queue2->push(new Job("job_".$i, "data_".$i));
}

//$queue1->clear();
//$queue2->clear();
