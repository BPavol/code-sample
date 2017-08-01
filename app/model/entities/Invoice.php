<?php

namespace App\Model\Entities;

class Invoice extends Entity
{
	protected static $FIELDS_DEFINITION = [
		'id' => [self::PRIMARY],
		'customer_id' => [self::INT_UNSIGNED],
		'name' => [self::STRING],
		'description' => [self::STRING],
		'price' => [self::DOUBLE_UNSIGNED],		
		'create_date' => [self::DATETIME],
		'creator_id' => [self::INT_UNSIGNED],
		'last_modify' => [self::DATETIME],
		'last_modifier_id' => [self::INT_UNSIGNED]
	];
	
	/** @var \Nette\Security\User */
	protected $user;
	
	/** @var ICustomerFactory */
	protected $customerFactory;
	
	/** @var Customer */
	protected $customer;
			
	public function __construct($id = null, \Nette\Security\User $user, \App\Model\Tables\InvoiceTable $invoiceTable, ICustomerFactory $customerFactory)
	{
		$this->id = $id;
		$this->user = $user;
		$this->table = $invoiceTable;
		$this->customerFactory = $customerFactory;
		
		$this->load();
	}
	
	/**
	* Insert new if not exist otherwise update
	* @return bool
	*/
	public function save()
	{	
		if (!isset($this->id)) {	
			$this->create_date = new \Nette\Database\SqlLiteral('NOW()');		
			$this->creator_id = $this->user->id;	
			
			$latestRow = $this->table->getTable()->order('id DESC')->limit(1)->fetch();
			if ($latestRow) {
				$this->id = date('ymd').str_pad(intval(substr($latestRow->id, -3))+1, 3, '0', STR_PAD_LEFT); // RRMMDDCCC
			} else {				
				$this->id = date('ymd000'); // First ID today
			}
			
			$newInvoice = $this->table->insert($this->values);
			$this->id = $newInvoice->id;
		} else { 
			$this->last_modify = new \Nette\Database\SqlLiteral('NOW()');		
			$this->last_modifier_id = $this->user->id;	
			$this->row->update($this->values);
		}

		$this->load();				

		return true;
	}
	
	public function getCustomer()
	{
		return isset($this->customer) ? $this->customer : $this->customer = $this->customerFactory->create($this->customer_id);
	}
}
