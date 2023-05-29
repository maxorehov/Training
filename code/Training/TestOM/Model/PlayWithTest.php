<?php

namespace Training\TestOM\Model;

use Training\TestOM\Model\Test;
use Training\TestOM\Model\ManagerCustomImplementation;

class PlayWithTest
{
    public function __construct(
        private Test $testObject,
        private TestFactory $testObjectFactory,
        private ManagerCustomImplementation $manager
    ) {

    }

    public function run()
    {
        $this->testObject->log();
        echo "<br/>";
        $customArrayList = ['item1' => 'aaaaa', 'item2' => 'bbbbb'];
        $newTestObject = $this->testObjectFactory->create([
            'arrayList' => $customArrayList,
            'manager' => $this->manager
        ]);
        $newTestObject->log();
        echo "<br/>";
    }

}
