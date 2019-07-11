<?php

namespace Sega\Extension\Block;

use \Magento\Backend\Block\Template,
    \Magento\Framework\App\Config\ScopeConfigInterface,
    \Magento\Backend\Block\Template\Context;

/**
 * Class Search
 * @package Sega\Extension\Block
 */
class Search extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context,
        $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed\
     */
    public function getActionUrl()
    {
        return $this->scopeConfig->getValue('extension/general/set_url');
    }
}