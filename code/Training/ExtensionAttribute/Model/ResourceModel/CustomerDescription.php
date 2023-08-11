<?php
declare(strict_types=1);
namespace Training\ExtensionAttribute\Model\ResourceModel;

class CustomerDescription extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('customer_description', 'id');
    }

    /**
     * @param $customerEmail
     * @return mixed
     */
    public function loadCustomerRelations($customerEmail)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->getTable('customer_description'), ['customer_description', 'can_show'])
            ->where('customer_email = ?', (string)$customerEmail);
        return $adapter->fetchRow($select);
    }

    /**
     * @param $customerEmail
     * @param $customerDescription
     * @return $this
     */
    public function saveCustomerRelations($customerEmail, $customerDescription)
    {
        $this->updateCustomerDescription($customerEmail, $customerDescription);
        return $this;
    }

    /**
     * @param $customerEmail
     * @param $customerDescription
     * @return void
     */
    private function updateCustomerDescription($customerEmail, $customerDescription)
    {
        $data = ['customer_description' => $customerDescription];
        $this->getConnection()->update('customer_description', $data, ['customer_email = ?' => (string)$customerEmail]);
    }

    public function createCustomerDescription($customerEmail)
    {
        $data = ['customer_email' => $customerEmail, 'customer_description' => '', 'can_show' => 1];
        $this->getConnection()->insert('customer_description', $data);
    }
}
