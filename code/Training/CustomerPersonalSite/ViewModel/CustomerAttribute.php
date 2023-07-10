<?php

namespace Training\CustomerPersonalSite\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
class CustomerAttribute implements ArgumentInterface
{
    /**
     * @param $customerData
     * @return string
     */
    public function getPersonalSite($customerData)
    {
        $attribute = $customerData->getCustomAttribute('personal_site');
        if ($attribute) {
            return $attribute->getValue();
        }
        return '';
    }
}
