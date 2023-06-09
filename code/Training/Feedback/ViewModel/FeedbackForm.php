<?php
declare(strict_types=1);

namespace Training\Feedback\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\UrlInterface;
class FeedbackForm implements ArgumentInterface
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }
    public function getActionUrl()
    {
        return $this->urlBuilder->getUrl('training_feedback/form/save');
    }
}
