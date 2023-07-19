<?php
declare(strict_types=1);

namespace Training\Feedback\Controller\Adminhtml\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Backend\Model\View\Result\ForwardFactory;
class NewAction implements ActionInterface
{
    const ADMIN_RESOURCE = 'Training_Feedback::feedback_save';

    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
