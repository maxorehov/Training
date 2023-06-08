<?php

namespace Training\Test\Controller\Page;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Cms\Controller\Page\View as ParentViewController;
use Magento\Cms\Helper\Page as PageHelper;
use Magento\Framework\App\RequestInterface;

class View extends ParentViewController
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Cms\Api\PageRepositoryInterface $pageRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository,
        RequestInterface $request,
        PageHelper $pageHelper
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->pageRepository = $pageRepository;
        parent::__construct($context, $request, $pageHelper, $resultForwardFactory);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            $data = ['status' => 'success', 'message' => ''];
            $pageId = $this->getRequest()->getParam('page_id', $this->getRequest()->getParam('id', false));
            $resultJson = $this->resultJsonFactory->create();
            try {
                $page = $this->pageRepository->getById($pageId);
                $data['title'] = $page->getTitle();
                $data['content'] = $page->getContent();
            } catch (NoSuchEntityException $e) {
                $data['status'] = 'error';
                $data['message'] = 'Not found';
            } catch (\Exception $e) {
                $data['status'] = 'error';
                $data['message'] = 'Something wrong';
            }
            $resultJson->setData($data);
            return $resultJson;
        }
        return parent::execute();
    }

}
