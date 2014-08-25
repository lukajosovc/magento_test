<?php
     
class Fsite_Test_Block_Adminhtml_Test_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
     
	public function __construct()
    {
    	parent::__construct();
        $this->setId('test_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('test')->__('Test Record'));
    }
     
    protected function _beforeToHtml()
    {
    	$this->addTab('form_section', array(
        	'label'     => Mage::helper('test')->__('General Tab'),
            'title'     => Mage::helper('test')->__('General Tab'),
            'content'   => $this->getLayout()->createBlock('test/adminhtml_test_edit_tab_form')->toHtml(),
        ));  
        return parent::_beforeToHtml();
    }
}