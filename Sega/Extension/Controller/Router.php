<?php

namespace Sega\Extension\Controller;

use Magento\Framework\App\ActionFactory,
    Magento\Framework\App\Config\ScopeConfigInterface,
    Magento\Framework\App\RequestInterface,
    Magento\Framework\App\RouterInterface,
    Magento\Framework\App\Action\Forward;

/**
 * Class Router
 * @package Sega\Extension\Controller
 */
class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ActionFactory $actionFactory, ScopeConfigInterface $scopeConfig)
    {
        $this->actionFactory = $actionFactory;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param RequestInterface $request
     * @return |null
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $configValue = $this->scopeConfig->getValue('extension/general/set_url');

        if ($identifier != $configValue) {
            return null;
        }

        $request->setModuleName('extension')->setControllerName('index')->setActionName('index');

        $this->actionFactory->create(Forward::class);
    }
}
