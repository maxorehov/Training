<?php

declare(strict_types=1);

namespace Training\TestPlugin\Controller\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use \Magento\Catalog\Controller\Product\View as ParentViewController;
use Magento\Catalog\Model\Design;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class View extends ParentViewController
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var RedirectFactory
     */
    private $redirectFactory;

    /**
     * @param Context $context
     * @param \Magento\Catalog\Helper\Product\View $viewHelper
     * @param ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     * @param LoggerInterface|null $logger
     * @param Data|null $jsonHelper
     * @param Design|null $catalogDesign
     * @param ProductRepositoryInterface|null $productRepository
     * @param StoreManagerInterface|null $storeManager
     * @param Session $customerSessin
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        \Magento\Catalog\Helper\Product\View $viewHelper,
        ForwardFactory $resultForwardFactory,
        PageFactory $resultPageFactory,
        ?LoggerInterface $logger = null,
        ?Data $jsonHelper = null,
        ?Design $catalogDesign = null,
        ?ProductRepositoryInterface $productRepository = null,
        ?StoreManagerInterface $storeManager = null,
        Session $customerSessin,
        RedirectFactory $redirectFactory
    )
    {
        $this->redirectFactory = $redirectFactory;
        $this->customerSession = $customerSessin;
        parent::__construct($context, $viewHelper, $resultForwardFactory, $resultPageFactory, $logger, $jsonHelper, $catalogDesign, $productRepository, $storeManager);
    }


    /**
     * @return \Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\Result\Redirect|void
     */
    public function execute()
    {
        if (!$this->customerSession->isLoggedIn()) {
            return $this->redirectFactory->create()->setPath('customer/account/login');
        }

        parent::execute();
    }
}
