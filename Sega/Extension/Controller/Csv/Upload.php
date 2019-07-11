<?php

namespace Sega\Extension\Controller\Csv;

use Magento\Framework\App\Action\Action,
    Magento\Framework\App\Action\Context,
    Magento\Framework\View\Result\PageFactory,
    Sega\Extension\Model\Csv\Upload as Import;


class Upload extends Action
{
    /**
     * @var
     */
    protected $pageFactory;

    /**
     * @var
     */
    protected $product;

    /**
     * @var Import
     */
    protected $csv;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Import $csv
    )
    {
        $this->pageFactory = $pageFactory;
        $this->csv = $csv;
        return parent::__construct($context);
    }
    public function execute()
    {
        $file = $this->getRequest()->getFiles('csv');
        $arrayImportProduct = $this->csv->csvImportFile($file);
        //return $this->PageFactory->create();
    }
}