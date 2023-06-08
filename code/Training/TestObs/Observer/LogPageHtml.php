<?php

declare(strict_types=1);

namespace Training\TestObs\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
class LogPageHtml implements ObserverInterface
{

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    )
    {
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $response = $observer->getEvent()->getData('response');
        $this->logger->debug($response->getBody());
    }
}
