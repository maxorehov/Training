<?php
declare(strict_types=1);

namespace Training\ExtensionAttribute\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class CustomerAttribute implements ArgumentInterface
{

    /**
     * @var \Training\ExtensionAttribute\Model\ResourceModel\CustomerDescription
     */
    public $resource;

    private $searchCriteriaBuilder;

    private $customerRepository;

    /**
     * @param \Training\ExtensionAttribute\Model\ResourceModel\CustomerDescription $resourse
     */
    public function __construct(
        \Training\ExtensionAttribute\Model\ResourceModel\CustomerDescription $resourse,
        \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    )
    {
        $this->resource = $resourse;
        $this->searchCriteriaBuilder = $searchCriteriaBuilderFactory->create();
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param $customerData
     * @return mixed
     */
    public function canShowDescription($customerData)
    {
        $this->test();
        return $customerData->getExtensionAttributes()->getCanShow();

    }

    /**
     * @param $customerData
     * @return mixed
     */
    public function getDescription($customerData)
    {
        return $customerData->getExtensionAttributes()->getDescription();
    }

    public function test()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $collection = $this->customerRepository->getList($searchCriteria);

        foreach ($collection->getItems() as $item) {
            $item->getExtensionAttributes();
        }
    }
}
