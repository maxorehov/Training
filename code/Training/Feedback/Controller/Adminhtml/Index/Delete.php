<?php
declare(strict_types=1);

namespace Training\Feedback\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ActionInterface;
use Training\Feedback\Api\FeedbackRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Delete implements ActionInterface
{
    const ADMIN_RESOURCE = 'Training_Feedback::feedback_delete';

    /**
     * @var FeedbackRepositoryInterface
     */
    private $feedbackRepository;

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
     * @param FeedbackRepositoryInterface $feedbackRepository
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        FeedbackRepositoryInterface $feedbackRepository,
        RequestInterface $request,
        ManagerInterface $messageManager,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->feedbackRepository = $feedbackRepository;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->request->getParam('feedback_id');
        if ($id) {
            try {
                $this->feedbackRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the feedback.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['feedback_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t delete the feedback.'));
                return $resultRedirect->setPath('*/*/edit', ['feedback_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a feedback to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
