<?php

namespace Training\Test\Controller\Index;

class Block extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    private $layoutFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    private $rawFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     * @param \Magento\Framework\Controller\Result\RawFactory $rawFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\Controller\Result\RawFactory $rawFactory
    ) {
        $this->layoutFactory = $layoutFactory;
        $this->rawFactory = $rawFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $layout = $this->layoutFactory->create();
        $raw = $this->rawFactory->create();
        $block = $layout->createBlock('Training\Test\Block\TestBlock');
        $raw->setContents($block->toHtml());
        return $raw;
    }
}
