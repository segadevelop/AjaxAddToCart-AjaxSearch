<?php

namespace Sega\Extension\Controller\Search;

use Magento\Framework\App\Action\Context,
    Magento\Framework\View\Result\PageFactory,
    Magento\Framework\App\Action\Action,
    Magento\Framework\Controller\Result\JsonFactory;

use Sega\Extension\Model\Product as Product;

/**
 * Class Index
 * @package Sega\Extension\Controller\Index
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var Product
     */
    protected $model;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Product $model,
        JsonFactory $resultJsonFactory
    ) {
        $this->model = $model;
        $this->pageFactory = $pageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        if ($inp = $this->getRequest()->getParams('data'))
        {
            $sku = $this->model->findBySKU( $this->getRequest()->getParam('search_sku') );
            return  $this->resultJsonFactory->create()->setData(['items' => array_keys($sku)]);
        }
    }
}
