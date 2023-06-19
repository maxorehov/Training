<?php

namespace Training\TestPlugin\Plugin\View;

class Layout
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\View\Layout $subject
     * @param $result
     * @return mixed
     */
    public function afterGenerateXml(\Magento\Framework\View\Layout $subject, $result)
    {

        $this->logger->info($result->getUpdate()->asSimplexml()->asXML());

        return $result;
    }

}
