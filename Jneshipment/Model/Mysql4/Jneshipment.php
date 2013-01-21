<?php

class Jne_Jneshipment_Model_Mysql4_Jneshipment extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('jneshipment/jneshipment', 'id');
    }
}