<?php
declare(strict_types=1);

namespace Ay\CustomerGraphQl\Block\Widget;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\OptionInterface;
use Magento\Customer\Block\Widget\AbstractWidget;
use Magento\Customer\Model\Session;

class Hobby extends AbstractWidget
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Address $addressHelper
     * @param CustomerMetadataInterface $customerMetadata
     * @param CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Address $addressHelper,
        CustomerMetadataInterface $customerMetadata,
        private CustomerRepositoryInterface $customerRepository,
        private Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $addressHelper, $customerMetadata, $data);
    }

    /**
     * Initialize block
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('Ay_CustomerGraphQl::widget/hobby.phtml');
    }

    /**
     * Retrieve store attribute label
     *
     * @param string $attributeCode
     *
     * @return string
     */
    public function getStoreLabel(string $attributeCode)
    {
        $attribute = $this->_getAttribute($attributeCode);
        return $attribute ? __($attribute->getStoreLabel()) : '';
    }

    /**
     * Get current customer from session
     *
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customerRepository->getById($this->customerSession->getCustomerId());
    }

    /**
     * Returns options from hobby attribute
     *
     * @return OptionInterface[]
     */
    public function getHobbyOptions(): array
    {
        return $this->_getAttribute('hobby')->getOptions();
    }
}
