<?php
/**
 * @package Bliss_Navigation
 */
namespace Bliss\Navigation\Helper;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Registry;

class Data extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var Registry
     */
    private $_registry;

    /**
     * Data constructor.
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param CollectionFactory $collectionFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        CollectionFactory $collectionFactory,
        Registry $registry
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_registry = $registry;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            'bliss_navigation/general/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function isEnabledPriceRangeSliders()
    {
        return $this->scopeConfig->getValue(
            'bliss_navigation/general/price_slider',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return array|bool|mixed|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCategoryAttribute()
    {
        if (!$this->_registry->registry('current_category')) {
            return false;
        }

        $catId = $this->_registry->registry('current_category')->getId();
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('apply_filter');
        $collection->addAttributeToFilter('entity_id', ['eq'=>$catId]);
        $collection->setPageSize(1);

        $catObj = $collection->getFirstItem();

        return $catObj->getData('apply_filter');
    }

    /**
     * @return array|bool|mixed|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSelectedAttribute()
    {
        if (!$this->_registry->registry('current_category')) {
            return false;
        }

        $catId = $this->_registry->registry('current_category')->getId();

        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('filter_list');
        $collection->addAttributeToFilter('entity_id', ['eq'=>$catId]);
        $collection->setPageSize(1);
        $catObj = $collection->getFirstItem();

        return $catObj->getData('filter_list');
    }
}
