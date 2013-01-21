<?php

class Jne_Jneshipment_Block_Adminhtml_Jneshipment_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	protected function _prepareCollection()
	{
;
		$collection = Mage::getModel('jneshipment/jneshipment')->getCollection();
//		$collection->setOrder('id');
//		$collection->getSelect()->join(
//				array('order' => 'sales_flat_order_grid'), 'main_table.order_id=order.increment_id', array('order.*'));
//		$collection->getSelect()->join(
//				array('order2' => 'sales_flat_order'), 'main_table.order_id=order2.increment_id', array('order2.*'));
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('order_id', array(
			'header' => Mage::helper('sales')->__('Order ID'),
			'index' => 'order_id',
		));

		$this->addColumn('AWB', array(
			'header' => Mage::helper('sales')->__('AWB'),
			'index' => 'awb',
		));

		$this->addColumn('action', array(
			'header' => Mage::helper('catalog')->__('Action'),
			'width' => '50px',
			'type' => 'action',
			'getter' => 'getId',
			'actions' => array(
				array(
					'caption' => Mage::helper('catalog')->__('Edit'),
					'url' => array(
						'base' => '*/*/edit',
						'params' => array('i' => $this->getRequest()->getParam('store'))
					),
					'field' => 'id'
				)
			),
			'filter' => false,
			'sortable' => false,
			'index' => 'stores',
		));

		$this->addExportType('*/*/exportCsv', Mage::helper('jneshipment')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('jneshipment')->__('XML'));

		return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}