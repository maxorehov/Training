<?php
declare(strict_types=1);

namespace Training\FeedbackProduct\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
class FeedbackDataLoader
{
    const PRODUCT_ID_FIELD = 'entity_id';
    const PRODUCT_SKU_FIELD = 'sku';

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder    $searchCriteriaBuilder,
        FilterBuilder            $filterBuilder

    )
    {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
    }


    /**
     * @param \Training\Feedback\Model\Feedback $feedback
     * @param $skus
     * @return mixed
     */
    public function addProductsToFeedbackBySkus(\Training\Feedback\Model\Feedback $feedback, $skus)
    {
        $feedback->getExtensionAttributes()
            ->setProducts($this->getProductsByField(self::PRODUCT_SKU_FIELD, $skus));
        return $feedback;
    }

    /**
     * @param \Training\Feedback\Model\Feedback $feedback
     * @param $ids
     * @return mixed
     */
    public function addProductsToFeedbackByIds($feedback, $ids)
    {
        $feedback->getExtensionAttributes()
            ->setProducts($this->getProductsByField(self::PRODUCT_ID_FIELD, $ids));
        return $feedback;
    }

    /**
     * @param $field
     * @param $value
     * @return array|\Magento\Catalog\Api\Data\ProductInterface[]
     */
    private function getProductsByField($field, $value)
    {
        if (!is_array($value) || !count($value)) {
            return [];
        }
        $skuFilter = $this->filterBuilder
            ->setField($field)
            ->setValue($value)
            ->setConditionType('in')
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters([$skuFilter])
            ->create();
        return $this->productRepository->getList($searchCriteria)->getItems();
    }
}
