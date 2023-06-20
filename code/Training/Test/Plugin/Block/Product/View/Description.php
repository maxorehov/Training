<?php

namespace Training\Test\Plugin\Block\Product\View;

class Description extends \Magento\Catalog\Block\Product\View\Description
{
    /**
     * @param \Magento\Catalog\Block\Product\View\Description $subject
     * @return void
     */
    public function beforeToHtml(
        \Magento\Catalog\Block\Product\View\Description $subject
    ) {
        $subject->setTemplate('Training_Test::description.phtml');
    }

}
