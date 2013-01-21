<?php

/**
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @category    Magemaven
 * @package     Magemaven_OrderComment
 * @copyright   Copyright (c) 2011-2012 Sergey Storchay <r8@r8.com.ua>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Jne_Jneshipment_Model_Observer extends Varien_Object
{

	/**
	 * Save comment from agreement form to order
	 *
	 * @param $observer
	 */
	public function adminOrder($observer)
	{
		$incrementid = $observer->getEvent()->getOrder()->getIncrementId();
		$model = Mage::getModel("jneshipment/jneshipment");
//		var_dump($model);exit;
		$model->setOrderId($incrementid);
		$model->setAwb(null);
		if ($model->save())
			return $this;
		else
			var_dump($model);exit;
		return $this;
	}
}
