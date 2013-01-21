<?php

/**
 * @category    Jne
 * @package     Jne_Jneshipment
 * @copyright   Copyright (c) 2013
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author		   Ambikuk - Technolyze team <http://technolyze.com>
 */

abstract class Jne_Jneshipment_Model_Carrier_Abstract extends Mage_Shipping_Model_Carrier_Abstract
{
	protected $_code = '';

	public function collectRates(Mage_Shipping_Model_Rate_Request $request)
	{
		
		if (!$this->getConfigFlag('active'))
		{
			return false;
		}

		$result = Mage::getModel('shipping/rate_result');

		if ($request->getAllItems())
		{
			foreach ($request->getAllItems() as $item)
			{
				$weight += ($item->getWeight() * $item->getQty());
			}
		}
		
	

		$customerAddressId = Mage::getSingleton('customer/session')->getCustomer()->getShipping();
		$query = "select * from jne_rate where kodepos=" . $request->getDestPostcode();
		$priceRate = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($query);

		$method = Mage::getModel('shipping/rate_result_method');
		if (isset($priceRate[0]))
		{
			$rowRate = $priceRate[0];

			if ($rowRate['harga_reg'] > 0)
			{
				$method = Mage::getModel('shipping/rate_result_method');
				$method->setCarrier($this->_code);
				$method->setCarrierTitle($this->_code);
				$method->setMethod('Jne Reguler');
				$method->setMethodTitle('Jne Reguler');
				$method->setPrice($rowRate['harga_reg']);
				$result->append($method);
			}

			if ($rowRate['harga_yes'] > 0)
			{
				$method = Mage::getModel('shipping/rate_result_method');
				$method->setCarrier($this->_code);
				$method->setCarrierTitle($this->_code);
				$method->setMethod('Jne Yes');
				$method->setMethodTitle('Jne Yes');
				$method->setPrice($rowRate['harga_yes']);
				$result->append($method);
			}

			if ($rowRate['harga_oke'] > 0)
			{
				$method = Mage::getModel('shipping/rate_result_method');
				$method->setCarrier($this->_code);
				$method->setCarrierTitle($this->_code);
				$method->setMethod('Jne Oke');
				$method->setMethodTitle('Jne Oke');
				$method->setPrice($rowRate['harga_oke']);
				$result->append($method);
			}
		}

		return $result;
	}

	public function getAllowedMethods()
	{
		return array($this->_code => $this->getConfigData('name'));
	}
}
