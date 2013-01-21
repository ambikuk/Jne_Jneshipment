<?php 

/**
 * @category    Jne
 * @package     Jne_Jneshipment
 * @copyright   Copyright (c) 2013
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author		   Ambikuk - Technolyze team <http://technolyze.com>
 */

class Jne_Jneshipment_Block_Available extends Mage_Checkout_Block_Onepage_Shipping_Method_Available
{
	protected function getInfoText($carrierCode)
	{
		if ($text = Mage::getStoreConfig('carriers/'.$carrierCode.'/infotext')) {
            return $text;
        }
        return '';
	}
}
