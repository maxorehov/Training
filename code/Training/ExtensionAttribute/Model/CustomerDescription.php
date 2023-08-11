<?php
declare(strict_types=1);

namespace Training\ExtensionAttribute\Model;

use Magento\Customer\Api\Data\CustomerInterface;
use Training\ExtensionAttribute\Model\ResourceModel\CustomerDescription as CustomerDescriptionResource;
use Training\ExtensionAttribute\Model\CustomerDescriptionDataLoader;
use Training\ExtensionAttribute\Api\Data\CustomerDescriptionInterface;

class CustomerDescription implements CustomerDescriptionInterface
{

    /**
     * @var CustomerDescriptionDataLoader
     */
    private $descriptionDataLoader;

    /**
     * @var CustomerDescriptionResource
     */
    private $customerDescriptionResource;

    /**
     * @param CustomerDescriptionResource $customerDescriptionResource
     * @param CustomerDescriptionDataLoader $descriptionDataLoader
     */
    public function __construct(
        CustomerDescriptionResource $customerDescriptionResource,
        CustomerDescriptionDataLoader $descriptionDataLoader
    )
    {
        $this->customerDescriptionResource = $customerDescriptionResource;
        $this->descriptionDataLoader = $descriptionDataLoader;
    }

    /**
     * @param CustomerInterface $customer
     * @return CustomerInterface|mixed|void
     */
    public function loadDescriptionRelations(CustomerInterface $customer)
    {
        $description = $this->customerDescriptionResource->loadCustomerRelations($customer->getEmail());
        if (!$description) {
            return ;
        }
        return $this->descriptionDataLoader->addDescriptionToCustomer($customer, $description);
    }

    /**
     * @param CustomerInterface $customer
     * @param string|null $description
     * @return void
     */
    public function saveDescriptionRelations(CustomerInterface $customer, string|null $description)
    {
        if (!$description) {
//            $this->customerDescriptionResource->createCustomerDescription($customer->getEmail());
            return;
        }
        $this->loadDescriptionRelations($customer);
        $this->customerDescriptionResource->saveCustomerRelations($customer->getEmail(), $description);

    }

}
