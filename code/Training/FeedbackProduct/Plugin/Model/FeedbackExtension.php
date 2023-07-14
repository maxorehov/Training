<?php
declare(strict_types=1);

namespace Training\FeedbackProduct\Plugin\Model;

use Training\Feedback\Api\Data\FeedbackExtensionInterfaceFactory;
use Training\Feedback\Api\Data\FeedbackInterface;

class FeedbackExtension
{
    /**
     * @var FeedbackExtensionInterfaceFactory
     */
    private $extensionAttributesFactory;

    /**
     * @param FeedbackExtensionInterfaceFactory $extensionAttributesFactory
     */
    public function __construct(
        FeedbackExtensionInterfaceFactory $extensionAttributesFactory
    ) {
        $this->extensionAttributesFactory = $extensionAttributesFactory;
    }

    /**
     * @param FeedbackInterface $subject
     * @param $result
     * @return mixed|\Training\Feedback\Api\Data\FeedbackExtensionInterface
     */
    public function afterGetExtensionAttributes(FeedbackInterface $subject, $result)
    {
        if (!is_null($result)) {
            return $result;
        }
        /** @var \Training\Feedback\Api\Data\FeedbackExtensionInterface $extensionAttributes */
        $extensionAttributes = $this->extensionAttributesFactory->create();
        $subject->setExtensionAttributes($extensionAttributes);
        return $extensionAttributes;
    }
}
