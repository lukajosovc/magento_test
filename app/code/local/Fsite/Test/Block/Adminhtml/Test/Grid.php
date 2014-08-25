<?php
     
class Fsite_Test_Block_Adminhtml_Test_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
    {
    	parent::__construct();
        $this->setId('testGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
	}
     
    protected function _prepareCollection()
    {
    	$collection = Mage::getModel('test/test')->getCollection();        
        $this->setCollection($collection);
       	return parent::_prepareCollection();
	}
     
    protected function _prepareColumns()
    {
    	$this->addColumn('id', array(
                'header'    => Mage::helper('test')->__('Id'),
                'align'     =>'right',
                'width'     => '50px',
                'index'     => 'id',
        ));
    	
    	$this->addColumn('first_name', array(
    			'header'    => Mage::helper('test')->__('First Name'),
    			'align'     =>'right',
    			'width'     => '50px',
    			'index'     => 'first_name',
    	));
    	
    	$this->addColumn('last_name', array(
    			'header'    => Mage::helper('test')->__('Last Name'),
    			'align'     =>'right',
    			'width'     => '50px',
    			'index'     => 'last_name',
    	));
    	
    	$this->addColumn('birth_date', array(
    			'header'    => Mage::helper('test')->__('Birth Date'),
    			'align'     => 'left',
    			'width'     => '60px',
    			'type'      => 'date',
    			'default'   => '--',
    			'index'     => 'birth_date',
    	));

    	$this->addColumn('created_at', array(
    			'header'    => Mage::helper('test')->__('Created At'),
    			'align'     => 'left',
    			'width'     => '60px',
    			'type'      => 'datetime',
    			'default'   => '--',
    			'index'     => 'created_at',
    	));
    	
    	$this->addColumn('updated_at', array(
    			'header'    => Mage::helper('test')->__('Updated At'),
    			'align'     => 'left',
    			'width'     => '60px',
    			'type'      => 'datetime',
    			'default'   => 'null',
    			'index'     => 'updated_at',
    	));
    	
    	return parent::_prepareColumns();
    }
     
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}