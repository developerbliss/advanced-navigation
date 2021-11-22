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
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * InstallData Class View
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param  ModuleDataSetupInterface $setup
     * @param  ModuleContextInterface   $context
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'apply_filter',
            [
                'type' => 'int',
                'label' => 'Remove All Filters',
                'input' => 'select',
                'sort_order' => 333,
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '0',
                'group' => 'General Information',
                'backend' =>'' ,
                'frontend' => ''
            ]
        );
    }
}
