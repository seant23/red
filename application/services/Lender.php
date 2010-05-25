<?php

/** 
 * @author seant23
 * 
 * 
 */
class Lender {
	
	/**
	 * Returns an array of Lender Details
	 * 
	 * @param int $lenderID Lender's ID
	 * @param mixed $additionalDetails You can pass an array of the other functions in this service to return additional details 
	 * 
	 * @return array An Array of the Lender's Details
	 */
	public function getDetails($lenderID, $additionalDetails=false) {
		$lender = array();
		
		$lender['lender'] = Zend_Db_Table::getDefaultAdapter ()->select()
				->from('lender')
				->where('lenderid = ?', (int) $lenderID)
				->query()
				->fetch();
			
		if(is_array($additionalDetails)) {
			
			if(in_array('contacts', $additionalDetails)) {
				$lender['contacts'] = $this->getContacts($lenderID);
			}
			
			if(in_array('products', $additionalDetails)) {
				$lender['products'] = $this->getProducts($lenderID);
			}
		
			if(in_array('notices', $additionalDetails)) {
				$lender['notices'] = $this->getNotices($lenderID);
			}
		}
		
		return $lender;
	}
	
	/**
	 * Returns a list of the known lender contacts for a given lenderid
	 * 
	 * @param int $lenderid Lender's ID
	 * 
	 * @return array An Array containing the known lender contacts
	 */
	public function getContacts($lenderID) {
		return Zend_Db_Table::getDefaultAdapter ()->select()
				->from('lender_contacts')
				->where('lenderid = ?', (int) $lenderID)
				->order('lastname')
				->query()
				->fetchAll();
	}
	
	/**
	 * Returns a list of the known lender products
	 * 
	 * @param int $lenderid Lender's ID
	 * 
	 * @return array An Array containing this lender's products
	 */
	public function getProducts($lenderID) {
		$lenderID = (int) $lenderID;
		
		return Zend_Db_Table::getDefaultAdapter ()->select()
				->from(array('p'=>'loan_product'))
				->joinLeft(array('lp'=>'lender_loan_product'), "p.loan_product_id = lp.loan_product_id AND lp.lenderid = $lenderID")
				->order('product_name')
				->query()
				->fetchAll();
	}
	
	/**
	 * Returns a list of this lender's notices
	 * 
	 * @param int $lenderid Lender's ID
	 * @param int $limit Number of notices to return
	 * 
	 * @return array An Array containing notices
	 */
	public function getNotices($lenderID, $limit=25) {
		$lenderID = (int) $lenderID;
		$contactID = LP_Employee::getContactID();
		
		return Zend_Db_Table::getDefaultAdapter ()->select()
				->from(array('n'=>'notices'))
				->joinLeft(array('l'=>'lender_loan_product'), "l.lenderid = n.lenderid")
				->joinLeft(array('en'=>'employee_notice'), "en.notice_id = n.notices_id AND en.contact_id = $contactID")
				->joinLeft(array('ens'=>'employee_notice_status'), "ens.employee_notice_status_id = en.employee_notice_status_id")
				->where('n.lenderid = ?', $lenderID)
				->limit($limit)
				->query()
				->fetchAll();
	}

}
