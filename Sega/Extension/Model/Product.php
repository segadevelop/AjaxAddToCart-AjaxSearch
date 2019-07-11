<?php
/**
 * Global Functional To Work Extension
 *
 * Sega_Dev >>>>>>>>>>> Amasty Extension Work Enterprise
 *
 * Model Logic:
 *
 */

namespace Sega\Extension\Model;

/**
 * All Resource Class Libs To Work Model Resource
 */
use Magento\Catalog\Api\ProductRepositoryInterface,
    Magento\Framework\Data\Form\FormKey,
    Magento\Checkout\Model\Cart,
    Magento\Framework\View\Result\PageFactory,
    Magento\Framework\Controller\Result\JsonFactory,
    Magento\Framework\App\Request\Http,
    Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection,
    Magento\Checkout\Controller\Cart\Add,
    Magento\Framework\App\Config\ScopeConfigInterface,
    Magento\Framework\Exception\NoSuchEntityException,
    Magento\Framework\DataObject\IdentityInterface,
    Magento\Framework\Model\AbstractModel,
    Magento\Framework\Model\ResourceModel\Db\AbstractDb,
    Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection,
    Magento\Framework\File\Csv;

use Magento\Framework\Data\CollectionFactory as DataCollection;

/**
 * Class Product
 * @package Sega\Extension\Model
 */
class Product
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Http
     */
    protected $request;

    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var CollectionFactory
     */
    protected $productCollection;

    protected $pageFactory;

    /**
     * Product constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param FormKey $formKey
     * @param Cart $cart
     * @param Http $request
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        FormKey $formKey,
        Cart $cart,
        Http $request,
        JsonFactory $jsonFactory,
        ProductCollection $productCollection,
        PageFactory $pageFactory
    ) {
        $this->productRepository = $productRepository;
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->request = $request;
        $this->jsonFactory = $jsonFactory;
        $this->productCollection = $productCollection;
        $this->pageFactory = $pageFactory;
    }

    /**
     * @param $productObj
     * @param $params
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addCustomProduct($productObj, $params)
    {
        $this->cart->addProduct($productObj, $params);
        $this->cart->save();
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductBySku()
    {
        $request = $this->request->getMethod();
        switch ($request)
        {
            case 'POST':
                $sku = $this->request->getParam('search_sku');
                    try {
                        $productObj = $this->productRepository->get($sku);
                        $product_id = $productObj->getId();
                        $params = [
                            'form_key'     => $this->formKey->getFormKey(),
                            'product_id'   => $product_id,
                            'qty'          => 1

                        ];



                        $this->addCustomProduct($productObj, $params);
                    }
                    catch (\Exception $e){
                        return 'Error';
                    }
                break;
            default:
            case 'GET':
                //
                break;
        }
    }

    /**
     * @param $sku
     * @return array
     */
    public function findBySKU ($sku) {
        $productCollection = $this->productCollection->create();
        $productCollection
            ->addFieldToFilter('sku', ['like' => $sku . '%'])
            ->setPageSize(15)
            ->setCurPage(1);
        $array = [];
        foreach ($productCollection as $product ) {
            $array[$product->getSku()] = $product->getSku();
        }
        return $array;
    }

    public function addAjaxProductCart()
    {
        //
    }

    public function addCsvListProduct()
    {
        //
    }
}
