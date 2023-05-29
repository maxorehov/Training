<?php

namespace Training\TestOM\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Training\TestOM\Model\PlayWithTest;
use Training\TestOM\Model\Test;

class Index implements ActionInterface

{
    public function __construct(
        private Test $test,
        private PlayWithTest $playWithTest
    )
    {

    }

    public function execute()
    {
       $this->test->log();
       echo "<br/>";
       echo "=====================================================" . "<br/>";
       $this->playWithTest->run();
       exit;
    }
}
