<?php
/**
 *	Magmi Import integration
 */

class MageHack_MagmiImport_Model_Convert_Adapter_Product extends Mage_Catalog_Model_Convert_Adapter_Product {

    /**
     * Save row (importdata)
     *
     * @param array $importData
     * @throws Mage_Core_Exception
     * @return bool
     */
    public function saveRow(array $importData) {
        Mage::log('Importing (fast)', null, 'magmi.log');

        return true;
    }

}
