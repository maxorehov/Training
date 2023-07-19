<?php
declare(strict_types=1);

namespace Training\Feedback\Controller\Adminhtml\Index;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ActionInterface;
use Training\Feedback\Api\FeedbackRepositoryInterface;
use Training\Feedback\Model\FeedbackFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Save implements ActionInterface
{
    const ADMIN_RESOURCE = 'Training_Feedback::feedback_save';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

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
     * @param DataPersistorInterface $dataPersistor
     * @param FeedbackRepositoryInterface $feedbackRepository
     * @param FeedbackFactory $feedbackFactory
     * @param RedirectFactory $resultRedirectFactory
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        DataPersistorInterface $dataPersistor,
        FeedbackRepositoryInterface $feedbackRepository,
        FeedbackFactory $feedbackFactory,
        RedirectFactory $resultRedirectFactory,
        RequestInterface $request,
        ManagerInterface $messageManager


    ) {
        $this->dataPersistor = $dataPersistor;
        $this->feedbackRepository = $feedbackRepository;
        $this->feedbackFactory = $feedbackFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->request = $request;
        $this->messageManager = $messageManager;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->request->getPostValue();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = \Training\Feedback\Model\Feedback::STATUS_ACTIVE;
            }
            if (empty($data['feedback_id'])) {
                $data['feedback_id'] = null;
            }
            $model = $this->feedbackFactory->create();
            $id = $this->request->getParam('feedback_id');
            if ($id) {
                try {
                    $model = $this->feedbackRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This feedback no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);
            try {
                $this->feedbackRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the feedback.'));
                $this->dataPersistor->clear('training_feedback');
                return $this->processRedirect($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager
                    ->addExceptionMessage($e, __('Something went wrong while saving the feedback.'));
            }
            $this->dataPersistor->set('training_feedback', $data);
            return $resultRedirect->setPath(
                '*/*/edit',
                ['feedback_id' => $this->getRequest()->getParam('feedback_id')]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $model
     * @param $data
     * @param $resultRedirect
     * @return mixed
     */
    private function processRedirect($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';
        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['feedback_id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}
