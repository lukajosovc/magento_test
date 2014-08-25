<?php
     
class Fsite_Test_Block_Adminhtml_Test_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
    {
    	parent::__construct();
                   
        $this->_objectId = 'id';
        $this->_blockGroup = 'test';
        $this->_controller = 'adminhtml_test';
     
        $this->_updateButton('save', 'label', Mage::helper('test')->__('Save Entry'));
        $this->_updateButton('delete', 'label', Mage::helper('test')->__('Delete Entry'));
	}
     
	public function getHeaderText()
    {
    	if(Mage::registry('test_data') && Mage::registry('test_data')->getId())
    	{
        	return Mage::helper('test')->__("Edit Entry Id : %s", $this->htmlEscape(Mage::registry('test_data')->getId()));
        }
        else
        {
        	return Mage::helper('test')->__('Add Entry');
        }
    }
}