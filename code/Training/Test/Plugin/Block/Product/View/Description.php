<?php

declare(strict_types=1);

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
        if ($subject->getNameInLayout() === 'product.info.sku') {
            $subject->setTemplate('Training_Test::description.phtml');
        }
//        $subject->setTemplate('Training_Test::description.phtml');
    }

}
