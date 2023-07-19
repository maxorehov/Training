<?php
declare(strict_types=1);

namespace Training\Feedback\Block\Adminhtml\Feedback\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{
    protected $context;
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * @return int
     */
    public function getFeedbackId()
    {
        return (int)$this->context->getRequest()->getParam('feedback_id');
    }

    /**
     * @param $route
     * @param $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
