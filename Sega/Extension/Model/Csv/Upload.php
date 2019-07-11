<?php

namespace Sega\Extension\Model\Csv;

use Magento\Framework\File\Csv,
    Magento\Framework\Exception\LocalizedException;

use Sega\Extension\Model\Product;

/**
 * Class Upload
 * @package Sega\Extension\Controller\Csv
 */
class Upload
{
    /**
     * @var Product
     */
    protected $product;

    protected $csvImport;

    public function __construct(
        Product $product,
        Csv $csvImport
    ) {
        $this->product = $product;
        $this->csvImport = $csvImport;
    }

    public function csvImportFile($file)
    {
        if (!isset($file['tmp_name'])) {
            throw new LocalizedException(__('Invalid file upload attempt.'));
        }
        $importProductRawData = $this->csvImport->getData($file['tmp_name']);
        $arrayProduct = [];
        foreach ($importProductRawData as $indexRow => $dataRow) {
            array_push($arrayProduct, $dataRow);
        }
    }
}
