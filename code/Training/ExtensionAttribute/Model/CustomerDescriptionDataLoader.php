<?php

namespace Training\ExtensionAttribute\Model;

use Magento\Customer\Api\Data\CustomerInterface;

class CustomerDescriptionDataLoader
{
    /**
     * @param CustomerInterface $customer
     * @param $description
     * @return CustomerInterface
     */
    public function addDescriptionToCustomer(CustomerInterface $customer, $description)
    {
        $customer->getExtensionAttributes()
            ->setDescription($description['customer_description'])
            ->setCanShow($description['can_show']);
        return $customer;
    }
}
