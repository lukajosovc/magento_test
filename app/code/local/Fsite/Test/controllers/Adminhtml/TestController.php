<?php
class Fsite_Test_Adminhtml_TestController extends Mage_Adminhtml_Controller_Action
{
    /* This save action needs to save new record data
     * as well as update any existing records.
     * 
     * Ensure any areas where exceptions could be generated are captured
     * and appropriate messages displayed back to the frontend.
     * 
     * Once complete please redirect to the IC test module.
     * 
     */
    public function saveAction()	// 5 marks
    {
    	$post_data = $this->getRequest()->getPost();
        
        if ($post_data) {
            try {
                // save 'updated_at' attribute to database
                if ($this->getRequest()->getParam('id')) {
                    $post_data['updated_at'] = now();
                }
                
                $model = Mage::getModel('test/test')
                    ->addData($post_data)
                    ->setId($this->getRequest()->getParam('id'))
                    ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Test record has been successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setLeadData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setLeadData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
       	
	/* This function needs to filter the records in the test module,  
	 * as specified in the question paper. Filter the collection, so
	 * that only records which HAVE "updated_at" values. (Any record
	 * contained in the data collection should therefore not have a null
	 * value for the "updated_at" field.)
	 * 
	 * Once the data collection has been filtered, create a new csv file
	 * and write every field in the model to csv, paying attention to 
	 * CSV format.
	 * 
	 * Close the file.
	 * 
	 * Save it to the root of the magento project, making sure the filename
	 * is called csvexport_timestamp.csv where timestamp is a standard php
	 * timestamp (just make sure the filename will always be unique).
	 * 
	 * Make sure any possible exceptions are caught, appropriate messages are displayed
	 * and that the action is redirected back to Grid page.
	 * 
	 * NOTE : Even if you cannot filter the data correctly, attempt to write any/all
	 * data to csv as you will be given marks for this.
	 * 
	 */
	
	public function exportCsvAction()	// 10 Marks
	{
        $fileName = 'csvexport_'. time() .'.csv';
        $content = '';
        
        try {
            $collection = Mage::getModel('test/test')->getCollection();
            $collection->addFieldToFilter('updated_at', array('neq' => 'null'));

            foreach ($collection->getData() as $item) {
                $content .= "\"{$item['id']}\",\"{$item['first_name']}\",\"{$item['last_name']}\",\"{$item['birth_date']}\",\"{$item['created_at']}\",\"{$item['updated_at']}\"\n";
            }
            
            $this->_prepareDownloadResponse($fileName, $content, 'text/csv');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
            return;
        }
	}
	
	/* This function needs to fetch all records in the module, that HAVE NOT been updated 
	 * (they must have null values in the "updated_at" fields).
	 * 
	 * Once the collection contains records according to the above criteria, please create an xml file,
	 * called "xml_export_time" where time is an actual, unique timestamp. timestamps are preffered but any 
	 * unique file names are acceptable.
	 * 
	 * The XML file should contain EACH RECORDS fields except the "updated_at" field.
	 * 
	 * As an example the file should look like :
	 * 
	 <?xml version="1.0"?>
	 <ORDERS>
	 	<ORDER>
		    <ID>2</ID>
		    <NAME>Jason</NAME>
		    <SURNAME>Bramsden</SURNAME>
		    <BIRTH_DATE>1987-01-10</BIRTH_DATE>
		    <CREATED_AT>2013-01-10 15:57:53</CREATED_AT>
	  	</ORDER>
	  	<ORDER>
		    <ID>4</ID>
		    <NAME>Andrew</NAME>
		    <SURNAME>Mori</SURNAME>
		    <BIRTH_DATE>2004-07-10</BIRTH_DATE>
		    <CREATED_AT>2013-01-10 20:18:48</CREATED_AT>
	  	</ORDER>
	 </ORDERS>
	 
	 * You are welcome to use any available technique to produce the file. (DOMDocument, SimpleXML, or anything else)
	 * 
	 * Save the file to the magento root rememeber to catch any possible exceptions.
	 *
	 * Redirect and back to the grid and display appropriate messages.
	 * 
	 */
	public function outputXMLAction()	// 10 Marks
	{
        $fileName = 'xml_export_'. time() .'.xml';
        $filePath = Mage::getBaseDir('base') . DS . 'var' . DS;
        
        try {
            $collection = Mage::getModel('test/test')->getCollection();
            $collection->addFieldToFilter('updated_at', array('null' => true));

            $xml = new SimpleXMLElement("<ORDERS></ORDERS>");
            foreach ($collection->getData() as $item) {
                // create order element
                $element = $xml->addChild("ORDER");
                $element->addChild("ID", $item['id']);
                $element->addChild("NAME", $item['first_name']);
                $element->addChild("SURNAME", $item['last_name']);
                $element->addChild("BIRTH_DATE", $item['birth_date']);
                $element->addChild("CREATED_AT", $item['created_at']);
            }
            
            // xml export
            $xml->saveXML($filePath . $fileName);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
            return;
        }
        $this->_redirect('*/*/');
	}
	
	/* This function needs to print out specific words for integer multiples between 1 and 500, defined by the following criteria.
	 *
	* For multiple's of 3, print "Black".
	* For multipple's of 5, print "Red"
	* For multiple's of both 3 and 5, print "BlackRed".
	*
	* Iterate to the number 500 (including 500, start at 1, not 0).
	*
	* Each print, is placed on a new line.
	*
	* Create a new txt file called "yourname.txt"(replace yourname with your actual name). Before this file is created, determine if "ic.txt" is found in the root of the magento
	* application. if it exists, delete the file.
	*
	* Once the file has been deleted (or confirmed that it does not exist), please create the file and write the correct words to it.
	*
	* Finally, save the file and programmatically transfer the file via SFTP :
	*
	* HOST		= localhost
	* PORT 	= 22
	* USERNAME = root
	* PASSWORD	= password
	* Local Directory : this is your magento root
	* Remote Directory : /home/magentotest/
	*
	*
	* Remember to catch any exceptions where neccessary and to display the errors or success messages properly when
	* redirecting the Grid. You are welcome to test your file first before sending it on.
	*/
	public function fsiteAction()	// 25 Marks
	{
	
	
	}
	
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('fsitemenu')
		->_setActiveMenu('fsitemenu/test')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Test Manager'), Mage::helper('adminhtml')->__('Tests'));
		return $this;
	}
	
	public function indexAction()
	{
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('test/adminhtml_test'));
		$this->renderLayout();
	}
	
	public function newAction()
	{
		$this->_forward('edit');
	}
	
	public function editAction()
	{
		$testId = $this->getRequest()->getParam('id');
		$testModel = Mage::getModel('test/test')->load($testId);
	
		if($testModel->getId() || $testId == 0)
		{
	
			Mage::register('test_data', $testModel);
			$this->loadLayout();
			 
			$this->_setActiveMenu('fsitemenu/test');
			 
			 
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			 
			$this->_addContent($this->getLayout()->createBlock('test/adminhtml_test_edit'))
			->_addLeft($this->getLayout()->createBlock('test/adminhtml_test_edit_tabs'));
			$this->renderLayout();
		}
		else
		{
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('test')->__('Test does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	public function deleteAction()
	{
		if($this->getRequest()->getParam('id') > 0)
		{
			try
			{
				$testModel = Mage::getModel('test/test');
				$testModel->setId($this->getRequest()->getParam('id'))
				->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Record was successfully deleted.'));
				$this->_redirect('*/*/');
			}catch (Exception $e)
			{
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
	
	/**
	 * Product grid for AJAX request.
     * Sort and filter result for example.
     */
	public function gridAction()
    {
    	$this->loadLayout();
        $this->getResponse()->setBody(
        	$this->getLayout()->createBlock('importedit/adminhtml_test_grid')->toHtml()
        );
    }
}