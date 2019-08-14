<?php
/**
 * KAbel_BundlePlus
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to a BSD 3-Clause License
 * that is bundled with this package in the file LICENSE_BSD_NU.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www1.unl.edu/wdn/wiki/Software_License
 *
 * @category    KAbel
 * @package     KAbel_BundlePlus
 * @copyright   Copyright (c) 2013 Regents of the University of Nebraska (http://www.nebraska.edu/)
 * @license     http://www1.unl.edu/wdn/wiki/Software_License  BSD 3-Clause License
 */

/**
 * Bundle option checkbox type renderer
 *
 * @category    KAbel
 * @package     KAbel_BundlePlus
 * @author      Kevin Abel <kabel2@unl.edu>
 */
class KAbel_BundlePlus_Block_Catalog_Product_View_Type_Bundle_Option_Checkbox
    extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle_Option_Checkbox
{
    protected function _construct()
    {
        $this->setTemplate('kabel/bundleplus/catalog/product/view/type/bundle/option/checkbox.phtml');
    }

    /**
     * Returns the selection qty for a checkbox selection
     *
     * @param Mage_Bundle_Model_Selection $selection
     * @return number
     */
    protected function _getSelectionQty($selection)
    {
        if ($this->getProduct()->hasPreconfiguredValues()) {
            $selectedQty = $this->getProduct()->getPreconfiguredValues()
                ->getData('bundle_option_qty/' . $this->getOption()->getId());
            if (is_array($selectedQty)) {
                if (isset($selectedQty[$selection->getSelectionId()])) {
                    $selectedQty = $selectedQty[$selection->getSelectionId()];
                } else {
                    $selectedQty = 0;
                }
            }

            $selectedQty = (float)$selectedQty;
            if ($selectedQty < 0) {
                $selectedQty = 0;
            }
        } else {
            $selectedQty = 0;
        }

        return $selectedQty;
    }
    
    /**
     * Gets the default values for a checkbox selection
     *
     * @param Mage_Bundle_Model_Selection $selection
     */
    protected function _getSelectionDefaultValues($selection)
    {
        $selectedOptions = $this->_getSelectedOptions();
        $_canChangeQty = (bool)$selection->getSelectionCanChangeQty();
    
        if ((empty($selectedOptions) && $selection->getIsDefault()) || !$_canChangeQty) {
            $_defaultQty = $selection->getSelectionQty()*1;
        } else {
            $_defaultQty = $this->_getSelectionQty($selection)*1;
        }
        
        
        return array($_defaultQty, $_canChangeQty);
    }
}
