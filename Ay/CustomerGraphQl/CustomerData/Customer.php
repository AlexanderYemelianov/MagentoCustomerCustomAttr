<?php
declare(strict_types=1);

namespace Ay\CustomerGraphQl\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Helper\View;
use Magento\Customer\Model\ResourceModel\CustomerFactory;

class Customer implements SectionSourceInterface
{
    /**
     * @param CurrentCustomer $currentCustomer
     * @param View $customerViewHelper
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        protected  CurrentCustomer $currentCustomer,
        private View $customerViewHelper,
        private CustomerFactory $customerFactory
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData() : array
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return [];
        }

        $customer = $this->currentCustomer->getCustomer();

        return [
            'fullname' => $this->customerViewHelper->getCustomerName($customer),
            'firstname' => $customer->getFirstname(),
            'websiteId' => $customer->getWebsiteId(),
            'hobby' => $this->getAttributeOptionText(
                (int) $customer->getCustomAttribute('hobby')->getValue()
            )
        ];
    }

    /**
     * @param int $attributeOptionId
     * @return string
     */
    private function getAttributeOptionText(int $attributeOptionId): string
    {
        /** @var \Magento\Customer\Model\ResourceModel\Customer $customerResourceModel */
        $customerResourceModel = $this->customerFactory->create();
        $result = '';

        try {
            $attribute = $customerResourceModel->getAttribute('hobby');

            if ($attribute) {
                $result = $attribute->getSource()->getOptionText($attributeOptionId);
            }
        } catch (\Exception $exception) {
            //TODO: Add logger.
        }

        return (string) $result;
    }
}
