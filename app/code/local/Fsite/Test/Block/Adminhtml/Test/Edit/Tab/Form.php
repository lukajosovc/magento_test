<?php
     
class Fsite_Test_Block_Adminhtml_Test_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
    	$form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('test_form', array('legend'=>Mage::helper('test')->__('Test Record')));
        
//         echo "<pre>";
//         print_r(Mage::registry('test_data')->getData());
//         exit;
        if(Mage::registry('test_data')->getId())
        {
	        $fieldset->addField('id', 'text', array(
	        		'label'     => Mage::helper('test')->__('id'),
	        		'name'      => 'id',
	        		'readonly'	=> 'true',
	        ));
        }
        
        $fieldset->addField('first_name', 'text', array(
        		'label'     => Mage::helper('test')->__('First Name'),
        		'name'      => 'first_name',
        		'class'		=> 'required',
        		'required'	=> 'true',
        ));
        
        $fieldset->addField('last_name', 'text', array(
        		'label'     => Mage::helper('test')->__('Last Name'),
        		'name'      => 'last_name',
        		'class'		=> 'required',
        		'required'	=> 'true',
        ));
        
        $fieldset->addField('birth_date', 'date', array(
        		'label'     => Mage::helper('test')->__('Birth Date'),
        		'name'      => 'birth_date',
        		'class'		=> 'required',
        		'required'	=> 'true',
        		'tabindex' => 1,
        		'image' => $this->getSkinUrl('images/grid-cal.gif'),
        		'format' => 'yyyy-MM-dd'
        ));
        
		if ( Mage::getSingleton('adminhtml/session')->getTestData())
		{
        	$form->setValues(Mage::getSingleton('adminhtml/session')->getTestData());
        	Mage::getSingleton('adminhtml/session')->setTestData(null);
       	}
       	elseif(Mage::registry('test_data'))
       	{
        	$form->setValues(Mage::registry('test_data')->getData());
        }
        return parent::_prepareForm();
	}
}