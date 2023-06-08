<?php
declare(strict_types=1);
namespace Training\Test\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\RawFactory;

class Raw implements ActionInterface
{

    /**
     * @param RawFactory $resultRawFactory
     */
    public function __construct(private RawFactory $resultRawFactory)
    {
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRaw = $this->resultRawFactory->create();
        $resultRaw->setContents('simple text RAW');
        return $resultRaw;
    }

}
