<?php

//

/**
 * IDEALIAGroup srl
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@idealiagroup.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category   IG
 * @package    Jne_Jneshipment
 * @copyright  Copyright (c) 2010-2011 IDEALIAGroup srl (http://www.idealiagroup.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Riccardo Tempesta <tempesta@idealiagroup.com>
 */
abstract class Jne_Jneshipment_Model_Carrier_Abstract extends Mage_Shipping_Model_Carrier_Flatrate
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
		$query = "select * from jneshipment where kodepos=" . $request->getDestPostcode();
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
