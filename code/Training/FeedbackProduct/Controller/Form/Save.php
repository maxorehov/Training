<?php
declare(strict_types=1);

namespace Training\FeedbackProduct\Controller\Form;

use Magento\Framework\App\ActionInterface;
use Training\Feedback\Model\FeedbackFactory;
use Training\Feedback\Model\ResourceModel\Feedback;

use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;

use Training\FeedbackProduct\Model\FeedbackDataLoader;

class Save implements ActionInterface
{
    /**
     * @var FeedbackFactory
     */
    private $feedbackFactory;

    /**
     * @var Feedback
     */
    private $feedbackResource;

    /**
     * @var FeedbackDataLoader
     */
    private $feedbackDataLoader;

    /**
     * @var RedirectFactory
     */
    private $resultRedirectFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @param FeedbackFactory $feedbackFactory
     * @param Feedback $feedbackResource
     * @param FeedbackDataLoader $feedbackDataLoader
     * @param RedirectFactory $resultRedirectFactory
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        FeedbackFactory $feedbackFactory,
        Feedback $feedbackResource,
        FeedbackDataLoader $feedbackDataLoader,
        RedirectFactory $resultRedirectFactory,
        RequestInterface $request,
        ManagerInterface $messageManager
    )
    {
        $this->feedbackFactory = $feedbackFactory;
        $this->feedbackResource = $feedbackResource;
        $this->feedbackDataLoader = $feedbackDataLoader;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->request = $request;
        $this->messageManager = $messageManager;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $result = $this->resultRedirectFactory->create();
        if ($post = $this->request->getPostValue()) {
            try {
                $this->validatePost($post);
                $feedback = $this->feedbackFactory->create();
                $feedback->setData($post);

                $this->setProductsToFeedback($feedback, $post);

                $this->feedbackResource->save($feedback);
                $this->messageManager->addSuccessMessage(
                    __('Thank you for your feedback.')
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('An error occurred while processing your form. Please try again later.')
                );
                $result->setPath('*/form/index');
            }
        }
        $result->setPath('*/form/index');
        return $result;
    }


    /**
     * @param \Training\Feedback\Model\Feedback $feedback
     * @param $post
     * @return void
     */
    private function setProductsToFeedback($feedback, $post)
    {
        $skus = [];
        if (isset($post['products_skus']) && !empty($post['products_skus'])) {
            $skus = explode(',', $post['products_skus']);
            $skus = array_map('trim', $skus);
            $skus = array_filter($skus);
        }
        $this->feedbackDataLoader->addProductsToFeedbackBySkus($feedback, $skus);
    }

    /**
     * @param $post
     * @return void
     * @throws \Exception
     */
    private function validatePost($post)
    {
        if (!isset($post['author_name']) || trim($post['author_name']) === '') {
            throw new LocalizedException(__('Name is missing'));
        }
        if (!isset($post['message']) || trim($post['message']) === '') {
            throw new LocalizedException(__('Comment is missing'));
        }

        if (!isset($post['author_email']) || false === \strpos($post['author_email'], '@')) {
            throw new LocalizedException(__('Invalid email address'));
        }
        if (trim($this->request->getParam('hideit')) !== '') {
            throw new \Exception();
        }
    }
}
