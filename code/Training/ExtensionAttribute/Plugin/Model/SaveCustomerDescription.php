<?php
declare(strict_types=1);

namespace Training\ExtensionAttribute\Plugin\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\RequestInterface;
use Training\ExtensionAttribute\Model\CustomerDescriptionFactory;

class SaveCustomerDescription
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var CustomerDescriptionFactory
     */
    private $customerDescriptionFactory;

    /**
     * @param RequestInterface $request
     * @param CustomerDescriptionFactory $customerDescriptionFactory
     */
    public function __construct(
        RequestInterface $request,
        CustomerDescriptionFactory $customerDescriptionFactory)
    {
        $this->request = $request;
        $this->customerDescriptionFactory = $customerDescriptionFactory;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function afterSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result,
        CustomerInterface $customer)
    {
        /** @var \Training\ExtensionAttribute\Model\CustomerDescription  $customerDescription */
        $customerDescription = $this->customerDescriptionFactory->create();
        $customerDescription->saveDescriptionRelations($customer, $this->request->getParam('customer_description'));
        return $result;
    }
}
