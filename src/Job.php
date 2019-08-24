<?php
/**
 * Created by PhpStorm.
 * User: volko
 * Date: 21.08.2019
 * Time: 12:48
 */

namespace Src;


class Job //класс задачи
{
    private $title; //название задачи
    private $data; //данные

    public function getTitle(){
        return $this->title;
    }
    public function getData(){
        return $this->data;
    }
    public function __construct($title, $data)
    {
        $this->title = $this->validateData($title);
        $this->data = $this->validateData($data);
    }

    public function handle(){ //выполнение задачи
        echo "Title: ".$this->getTitle().", data: ".$this->getData()."\n";
    }

    protected function validateData($data){ //валидирует входящие данные
        return $data;
    }
}