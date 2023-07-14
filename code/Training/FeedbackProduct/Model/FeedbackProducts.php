<?php
declare(strict_types=1);

namespace Training\FeedbackProduct\Model;

use Training\FeedbackProduct\Model\FeedbackDataLoader;
use Training\FeedbackProduct\Model\ResourceModel\FeedbackProducts as FeedbackProductsResource;

class FeedbackProducts
{
    /**
     * @var FeedbackDataLoader
     */
    private $feedbackDataLoader;

    /**
     * @var FeedbackProductsResource
     */
    private $feedbackProductsResource;

    public function __construct(
        FeedbackDataLoader $feedbackDataLoader,
        FeedbackProductsResource $feedbackProductsResource
    )
    {
        $this->feedbackDataLoader = $feedbackDataLoader;
        $this->feedbackProductsResource = $feedbackProductsResource;
    }

    /**
     * @param \Training\Feedback\Model\Feedback $feedback
     * @return mixed
     */
    public function loadProductRelations($feedback)
    {
        $productIds = $this->feedbackProductsResource->loadProductRelations($feedback->getId());
        return $this->feedbackDataLoader->addProductsToFeedbackByIds($feedback, $productIds);
    }

    /**
     * @param \Training\Feedback\Model\Feedback $feedback
     * @return $this
     */
    public function saveProductRelations($feedback)
    {

        $productIds = [];
        $products = $feedback->getExtensionAttributes()->getProducts();
        if (is_array($products)) {
            foreach ($products as $product) {
                $productIds[] = $product->getId();
            }
        }
        $this->feedbackProductsResource->saveProductRelations($feedback->getId(), $productIds);
        return $this;
    }
}
