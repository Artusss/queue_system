<?php
/**
 * Created by PhpStorm.
 * User: volko
 * Date: 21.08.2019
 * Time: 12:49
 */

namespace Queue;
use Src;

class QueueDB extends Queue //класс очереди с хранением в бд
{
    public $id; //id очереди в бд
    private $title; //название
    private $server; //экземпляр pdo через класс подключения Server

    public function __construct($title, $connect)
    {
        $this->title = $title;
        $this->server = $connect;
        $this->insertQueue($title);
        $this->id = $this->setId($title);
    }

    private function insertQueue($title){ //добавляет очередь, если ее нет в бд
        try{
            $pdo = $this->server;
            $query = "INSERT IGNORE INTO queues SET title = (?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$title]);
            unset($pdo, $query, $stmt);

        }catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    private function setId($title){ //возвращает id очереди из бд
        try{
            $pdo = $this->server;
            $query = "SELECT id FROM queues WHERE title = (?) LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$title]);
            $id = $stmt->fetch()['id'];
            unset($pdo, $query, $stmt);
            return $id;
        }catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public function push(Src\Job $job){ //добавляет задачу в очередь и возвращает id задачи
        try{
            $pdo = $this->server;
            $query = "INSERT IGNORE INTO jobs (queue_id, title, data) VALUES ((?), (?), (?))";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$this->id, $job->GetTitle(), $job->getData()]);
            $lastInsertId = $pdo->lastInsertId();
            unset($pdo, $query, $stmt);
            return $lastInsertId;
        }catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public function pop(){ //удаляет из очереди первую задачу и возвращает ее экземпляр
        try{
            $this->finishQueue("Queue is empty.\n");
            $pdo = $this->server;
            $query = "SELECT * FROM jobs WHERE queue_id = (?) LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$this->id]);
            $job_fetch = $stmt->fetch();
            $this->deleteById($job_fetch['id']);
            unset($pdo, $query, $stmt);
            return new Src\Job($job_fetch['title'], $job_fetch['data']);
        }catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    private function finishQueue($message){ //заканчивает выполнение очереди
        if($this->size() === 0){
            die($message);
        }
    }

    private function deleteById($id){ //удаляет задачу из таблицы очередей по ее id
        $pdo = $this->server;
        $query = "DELETE FROM jobs WHERE id = (?) LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        unset($pdo, $query, $stmt);
    }

    public function size(){ //возвращает колличество задач в очереди
        try{
            $pdo = $this->server;
            $query = "SELECT COUNT(id) AS size FROM jobs WHERE queue_id = (?) LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$this->id]);
            $size = $stmt->fetch()['size'];
            unset($pdo, $query, $stmt);
            return $size;
        }catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public function clear(){ //удаляет все задачи данной очереди
        try{
            $pdo = $this->server;
            $query = "DELETE FROM jobs WHERE queue_id = (?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$this->id]);
            $this->deleteById($this->id);
            unset($pdo, $query, $stmt);
        }catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }
}