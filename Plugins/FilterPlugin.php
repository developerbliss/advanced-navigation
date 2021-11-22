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

namespace Bliss\Navigation\Plugins;

use Magento\Catalog\Model\Layer\FilterList;
use Magento\Framework\App\Request\Http;
use Bliss\Navigation\Helper\Data;
use Magento\Framework\App\View;

/**
 * FilterPlugin Class View
 */
class FilterPlugin
{
    /**
     * @var Http
     */
    private $request;
    /**
     * @var Data
     */
    private $helper;
    /**
     * @var View
     */
    private $layout;

    /**
     * FilterPlugin constructor.
     *
     * @param Http $request
     * @param Data $helper
     * @param View $layout
     */
    public function __construct(
        Http $request,
        Data $helper,
        View $layout
    ) {
        $this->request = $request;
        $this->helper = $helper;
        $this->layout = $layout;
    }

    /**
     * @param  FilterList $subject
     * @param  $result
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterGetFilters(FilterList $subject, $result)
    {
        $key = $this->helper->getSelectedAttribute();
        $item = explode(',', $key);
        $currentLayout = $this->layout->getLayout()->getUpdate()->getHandles()[1];

        if (!$this->helper->isEnabled()) {
            return $result;
        }

        if ($currentLayout == 'catalogsearch_result_index') {
            return $result;
        }

        if ($this->helper->getCategoryAttribute() == '0') {
            return $result;
        }

        if ($this->helper->getCategoryAttribute() == '1') {
            if ($this->helper->getSelectedAttribute() !=null) {
                $count = 0;
                foreach ($result as $r) {
                    if (!in_array($r->getName(), $item)) {
                        unset($result[$count]);
                    }
                    $count++;
                }
                return $result;
            } else {
                return [];
            }
        } else {
            return $result;
        }
    }
}
