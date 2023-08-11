<?php

namespace Training\ExtensionAttribute\Api\Data;

interface CustomerDescriptionInterface
{
    /**
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function loadDescriptionRelations(\Magento\Customer\Api\Data\CustomerInterface $customer);

    /**
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param string|null $description
     * @return mixed
     */
    public function saveDescriptionRelations(\Magento\Customer\Api\Data\CustomerInterface $customer, string|null $description);
}
