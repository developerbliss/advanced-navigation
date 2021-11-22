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

namespace Bliss\Navigation\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * UpgradeData Class View
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
    * @var EavSetupFactory
    */
    private $eavSetupFactory;

    /**
    * Init
    *
    * @param EavSetupFactory $eavSetupFactory
    */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), '3.5.0') < 0) {
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'filter_list',
                [
                    'type'              => 'varchar',
                    'backend'           => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'label'             => __('All Filter'),
                    'input'             => 'select',
                    'required'          => false,
                    'sort_order'        => 5,
                    'global'            => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'wysiwyg_enabled' => false,
                    'is_html_allowed_on_front' => false,
                    'group' => __('General Information'),
                ]
            );
        }
    }
}
