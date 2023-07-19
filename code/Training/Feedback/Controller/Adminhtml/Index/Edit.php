<?php
declare(strict_types=1);

namespace Training\Feedback\Controller\Adminhtml\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Training\Feedback\Api\FeedbackRepositoryInterface;
use Training\Feedback\Model\FeedbackFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Edit implements ActionInterface
{
    const ADMIN_RESOURCE = 'Training_Feedback::feedback_save';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var FeedbackRepositoryInterface
     */
    private $feedbackRepository;

    /**
     * @var FeedbackFactory
     */
    private $feedbackFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var RedirectFactory
     */
    private $resultRedirectFactory;

    /**
     * @param PageFactory $resultPageFactory
     * @param FeedbackRepositoryInterface $feedbackRepository
     * @param FeedbackFactory $feedbackFactory
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        PageFactory $resultPageFactory,
        FeedbackRepositoryInterface $feedbackRepository,
        FeedbackFactory $feedbackFactory,
        RequestInterface $request,
        ManagerInterface $messageManager,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->feedbackRepository = $feedbackRepository;
        $this->feedbackFactory = $feedbackFactory;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $id = $this->request->getParam('feedback_id');
        $model = $this->feedbackFactory->create();
        if ($id) {
            try {
                $model = $this->feedbackRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This feedback no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('Training_Feedback::feedback')
            ->addBreadcrumb(__('Feedbacks'), __('Feedbacks'))
            ->addBreadcrumb(
                $id ? __('Edit Feedback') : __('New Feedback'),
                $id ? __('Edit Feedback') : __('New Feedback')
            );
        return $resultPage;
    }
}
