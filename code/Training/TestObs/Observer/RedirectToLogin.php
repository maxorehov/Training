<?php

declare(strict_types=1);

namespace Training\TestObs\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\Event\Observer;
class RedirectToLogin implements ObserverInterface
{

    /**
     * @param RedirectInterface $redirect
     * @param ActionFlag $actionFlag
     */
    public function __construct(
       private RedirectInterface $redirect,
       private ActionFlag $actionFlag
    ) {

    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $request = $observer->getEvent()->getData('request');
        if ($request->getModuleName() == 'catalog'
            && $request->getControllerName() == 'product'
            && $request->getActionName() == 'view'
        ) {
// if ($request->getFullActionName() == 'catalog_product_view') { // altenative way
            $controller = $observer->getEvent()->getData('controller_action');
            $this->actionFlag->set('', \Magento\Framework\App\ActionInterface::FLAG_NO_DISPATCH, true);
            $this->redirect->redirect($controller->getResponse(), 'customer/account/login');
        }
    }
}
