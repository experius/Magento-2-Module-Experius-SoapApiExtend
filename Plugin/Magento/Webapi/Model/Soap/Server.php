<?php


namespace Experius\SoapApiExtend\Plugin\Magento\Webapi\Model\Soap;

class Server
{
    /**
     * @var \Magento\Framework\Config\ScopeInterface
     */
    protected $configScope;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\AreaLIst
     */
    protected $areaList;

    /**
     * Server constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Config\ScopeInterface $configScope
     * @param \Magento\Framework\App\AreaList $areaList
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Config\ScopeInterface $configScope,
        \Magento\Framework\App\AreaList $areaList
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->configScope = $configScope;
        $this->storeManager = $storeManager;
        $this->areaList = $areaList;
    }

    /**
     * @param \Magento\Webapi\Model\Soap\Server $subject
     * @param $result
     * @return string
     */
    public function afterGetEndpointUri(
        \Magento\Webapi\Model\Soap\Server $subject,
        $result
    ) {
        $storeCode = $this->storeManager->getStore()->getCode() === \Magento\Store\Model\Store::ADMIN_CODE
            ? \Magento\Webapi\Controller\PathProcessor::ALL_STORE_CODE
            : $this->storeManager->getStore()->getCode();
        return $this->scopeConfig->getValue(
                'web/secure/base_url',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            )
            . $this->areaList->getFrontName($this->configScope->getCurrentScope())
            . '/' . $storeCode;

    }
}
