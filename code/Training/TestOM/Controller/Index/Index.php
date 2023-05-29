<?php

namespace Training\TestOM\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Training\TestOM\Model\Test;

class Index implements ActionInterface

{
    public function __construct(public Test $test)
    {

    }

    public function execute()
    {
       $this->test->log();
       exit;
    }
}
