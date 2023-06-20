<?php

declare(strict_types=1);

namespace Training\Test\Controller\Action;

use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\App\ActionInterface;

class Index implements ActionInterface
{
    /**
     * @var RawFactory
     */
    private $resultRawFactory;
    /**
     * @var LayoutFactory
     */
    private $layoutFactory;

    /**
     * @param RawFactory $resultRawFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        RawFactory $resultRawFactory,
        LayoutFactory $layoutFactory
    ) {
        $this->layoutFactory = $layoutFactory;
        $this->resultRawFactory = $resultRawFactory;
    }

    public function execute()
    {
        $layout = $this->layoutFactory->create();
        $block = $layout->createBlock('Magento\Framework\View\Element\Template');
        $block->setTemplate('Training_Test::test.phtml');
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents($block->toHtml());
    }
}
