<?php

class Jne_Jneshipment_Model_Mysql4_Jneshipment_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('jneshipment/jneshipment');
    }
}