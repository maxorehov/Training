<?php

declare(strict_types=1);

namespace Training\Test\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->getResponse()->appendBody('simple text');
    }
}
