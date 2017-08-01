<?php

namespace App\Model\Entities;

class Customer extends Entity
{
	protected static $FIELDS_DEFINITION = [
		'id' => [self::PRIMARY],
		'email' => [self::STRING],
		'name' => [self::STRING],
		'surname' => [self::STRING],
		'country_id' => [self::INT_UNSIGNED],
		'city' => [self::STRING],
		'postal_code' => [self::STRING],
		'street' => [self::STRING],		
		'company_reg_id' => [self::STRING],
		'tax_id' => [self::STRING],
		'vat_number' => [self::STRING],		
		'create_date' => [self::DATETIME],
		'creator_id' => [self::INT_UNSIGNED],
		'last_modify' => [self::DATETIME],
		'last_modifier_id' => [self::INT_UNSIGNED]
	];
	
	/** @var \Nette\Security\User */
	protected $user;
			
	public function __construct($id = null, \Nette\Security\User $user, \App\Model\Tables\CustomerTable $customerTable)
	{
		$this->id = $id;
		$this->user = $user;
		$this->table = $customerTable;
		
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
			$newCustomer = $this->table->insert($this->values);
			$this->id = $newCustomer->id;
		} else { 
			$this->last_modify = new \Nette\Database\SqlLiteral('NOW()');		
			$this->last_modifier_id = $this->user->id;	
			$this->row->update($this->values);
		}

		$this->load();				

		return true;
	}
}
