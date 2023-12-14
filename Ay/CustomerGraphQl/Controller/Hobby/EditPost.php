<?php
declare(strict_types=1);

namespace Ay\CustomerGraphQl\Controller\Hobby;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Controller\AbstractAccount;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Data\Form\FormKey\Validator;

class EditPost extends AbstractAccount implements HttpPostActionInterface
{
    /**
     * @param Context $context
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param Validator $formKeyValidator
     */
    public function __construct(
        Context $context,
        private Session $customerSession,
        private CustomerRepositoryInterface $customerRepository,
        private Validator $formKeyValidator
    ) {
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {
            try {
                $currentCustomerDataObject = $this->getCustomerDataObject((int) $this->customerSession->getCustomerId());
                $currentCustomerDataObject->setCustomAttribute(
                    'hobby',
                    $this->getRequest()->getParam('hobby', '')
                );

                $this->customerRepository->save($currentCustomerDataObject);
                $this->messageManager->addSuccessMessage(__('You saved the hobby information.'));
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage(
                    $exception,
                    __('We can\'t save your hobby customer. Exception: %1', $exception->getMessage())
                );
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/hobby/edit');

        return $resultRedirect;
    }

    /**
     * @param int $customerId
     *
     * @return CustomerInterface
     */
    private function getCustomerDataObject(int $customerId): CustomerInterface
    {
        return $this->customerRepository->getById($customerId);
    }
}
