<?php
declare(strict_types=1);

namespace Training\Js\Controller\Qty;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Framework\Controller\ResultFactory;

class Index implements ActionInterface
{

    /**
     * @var JsonFactory
     */
    private $jsonResultFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var StockItemRepository
     */
    private $stockRepository;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @param JsonFactory $jsonResultFactory
     * @param RequestInterface $request
     * @param StockItemRepository $stockRepository
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        JsonFactory $jsonResultFactory,
        RequestInterface $request,
        StockItemRepository $stockRepository,
        ResultFactory $resultFactory
    ) {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->request = $request;
        $this->stockRepository = $stockRepository;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        if (!$this->request->isAjax()) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setRefererUrl();
            return $resultRedirect;
        }

        $result = $this->jsonResultFactory->create();
        $productQty = $this->stockRepository->get($this->request->getParam('productId'))->getQty();
        $data = ['qty' => $productQty];
        $result->setJsonData(json_encode($data));
        return $result;
    }

}
