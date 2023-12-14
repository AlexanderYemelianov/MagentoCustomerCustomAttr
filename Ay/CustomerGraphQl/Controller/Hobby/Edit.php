<?php
declare(strict_types=1);

namespace Ay\CustomerGraphQl\Controller\Hobby;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Edit extends AbstractAccount implements HttpGetActionInterface
{
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        private PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    /**
     * @return Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
