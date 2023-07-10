<?php
declare(strict_types=1);

namespace Training\Feedback\Controller\Form;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    private $pageResultFactory;

    /**
     * @param PageFactory $pageResulFactory
     */
    public function __construct(PageFactory $pageResulFactory)
    {
        $this->pageResultFactory = $pageResulFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        return $this->pageResultFactory->create();
    }
}
