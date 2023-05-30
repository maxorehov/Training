<?php

namespace Training\TestPlugin\Plugin\Controller\Product;

use Magento\Customer\Model\Session;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Catalog\Controller\Product\View as BaseView;

class View
{

    public function __construct(
        private Session $customerSession,
        private RedirectFactory $redirectFactory
    ) {
    }
    public function aroundExecute(BaseView $subject, callable $proceed
    )
    {
        if (!$this->customerSession->isLoggedIn()) {
            return $this->redirectFactory->create()->setPath('customer/account/login');
        }
        return $proceed();
    }
}
