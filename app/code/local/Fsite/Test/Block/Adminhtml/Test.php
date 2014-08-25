<?php

class Fsite_Test_Block_Adminhtml_Test extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
    	$this->_controller = 'adminhtml_test';
        $this->_blockGroup = 'test';
        $this->_headerText = Mage::helper('test')->__('Fsite Test Module');
        
        $this->_addButtonLabel = Mage::helper('test')->__('Add Record');
        
        $this->_addButton('exportcsv', array(
        		'label'     => Mage::helper('test')->__('Export Csv'),
        		'onclick'   => 'setLocation(\'' . $this->getUrl('test/adminhtml_test/exportCsv') . '\')',
        ));
        
        $this->_addButton('outputxml', array(
        		'label'     => Mage::helper('test')->__('Output XML'),
        		'onclick'   => 'setLocation(\'' . $this->getUrl('test/adminhtml_test/outputXML') . '\')',
        ));
        
        $this->_addButton('ic', array(
        		'label'     => Mage::helper('test')->__('Fsite Commerce'),
        		'onclick'   => 'setLocation(\'' . $this->getUrl('test/adminhtml_test/fsite') . '\')',
        ));
        
        parent::__construct();
        //$this->_removeButton('add');
    }
}