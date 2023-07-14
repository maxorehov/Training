<?php
declare(strict_types=1);
namespace Training\FeedbackProduct\Observer;

use Magento\Framework\Event\ObserverInterface;
use Training\FeedbackProduct\Model\FeedbackProducts;
class LoadFeedbackProducts implements ObserverInterface
{

    /**
     * @var FeedbackProducts
     */
    private $feedbackProducts;

    /**
     * @param FeedbackProducts $feedbackProducts
     */
    public function __construct(
        FeedbackProducts $feedbackProducts
    ) {
        $this->feedbackProducts = $feedbackProducts;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $feedback = $observer->getFeedback();
        $this->feedbackProducts->loadProductRelations($feedback);
    }
}
