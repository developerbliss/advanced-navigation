<?php
/**
 * Bliss Navigation
 * php version 7.4
 *
 * @category Extension
 * @package  Bliss_Navigation
 * @author   Bliss <support@blisswebsolution.com>
 * @license  Open Source Licence https://opensource.org/licenses/MIT
 * @link     <blisswebsolution.com>
 */

namespace Bliss\Navigation\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * ProductAttributes Class View
 */
class ProductAttributes extends AbstractSource
{
    /**
     * @var CollectionFactory
     */
    private $productAttributeCollectionFactory;

    /**
     * ProductAttributes constructor.
     * @param CollectionFactory $productAttributeCollectionFactory
     */
    public function __construct(
        CollectionFactory $productAttributeCollectionFactory
    ) {
        $this->productAttributeCollectionFactory = $productAttributeCollectionFactory;
    }

    /**
     * @return array|mixed
     */
    public function getAllOptions()
    {
        $productAttributes = $this->productAttributeCollectionFactory->create();

        $productAttributes->addFieldToFilter(
            ['is_filterable', 'is_filterable_in_search'],
            [[1, 2], 1]
        );

        $productAttribute = array();

        foreach ($productAttributes as $attribute) {
            $productAttribute[] = [ 'value' => $attribute->getFrontendLabel(),
                'label' => $attribute->getFrontendLabel()
            ];
        }

        return $productAttribute;
    }
}
