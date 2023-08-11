<?php
declare(strict_types=1);

namespace Training\ExtensionAttribute\Plugin\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterfaceFactory;
use Training\ExtensionAttribute\Model\CustomerDescriptionFactory;

class LoadCustomerDescription
{
    /**
     * @var CustomerExtensionInterfaceFactory
     */
    private $extensionAttributesFactory;

    /**
     * @var CustomerDescriptionFactory
     */
    private $customerDescriptionFactory;

    /**
     * @param CustomerExtensionInterfaceFactory $extensionAttributesFactory
     * @param CustomerDescriptionFactory $customerDescriptionFactory
     */
    public function __construct(
        CustomerExtensionInterfaceFactory $extensionAttributesFactory,
        CustomerDescriptionFactory $customerDescriptionFactory
    ) {
        $this->extensionAttributesFactory = $extensionAttributesFactory;
        $this->customerDescriptionFactory = $customerDescriptionFactory;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @return CustomerInterface
     */
    public function afterGetById(CustomerRepositoryInterface $subject, CustomerInterface $result)
    {
        /**  @var \Training\ExtensionAttribute\Model\CustomerDescription  $customerDescriptionFactory */
        $customerDescriptionFactory = $this->customerDescriptionFactory->create();
        $customerDescriptionFactory->loadDescriptionRelations($result);
        return $result;
    }

}
