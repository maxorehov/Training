<?php

namespace Training\TestOM\Model;

class Test
{

    public function __construct(
        private ManagerInterface $manager,
        private $name,
        private int $number,
        private array $arrayList
    ) {}



    public function log()
    {
        print_r(get_class($this->manager));
        echo '<br>';
        print_r($this->name);
        echo '<br>';
        print_r($this->number);
        echo '<br>';
        print_r($this->arrayList);
    }
}
