<?php

namespace App\Forms;

trait formComponents
{
	/** @var \App\Model\Tables\CountryTable */
	private $countryTable;
	
	/** @var \App\Model\Tables\CustomerTable */
	private $customerTable;
		
	public function __construct(
		\Nette\ComponentModel\IContainer $parent = NULL, 
		$name = NULL,
		\App\Model\Tables\CountryTable $countryTable,
		\App\Model\Tables\CustomerTable $customerTable
	)
	{
		parent::__construct($parent, $name);
		
		$this->countryTable = $countryTable;
		$this->customerTable = $customerTable;
	}
	
	/**
	 * Adds naming container to the form.
	 * @param  string  name
	 * @return \App\Components\Form\Container
	 */
	public function addContainer($name)
	{
		$control = new Container(NULL, NULL, $this->countryTable, $this->customerTable);
		$control->currentGroup = $this->currentGroup;
		return $this[$name] = $control;
	}
	
	/**
	 * @return \App\Components\Form\ArrayCheckbox
	 */
	public function addArrayCheckbox($name, $label = NULL)
	{
		return $this[$name] = new ArrayCheckbox($label);
	}
	
	public function addCustomerSelectBox($name, $label = null, array $items = null)
		{			
		return 	$this[$name] = new CustomerSelectBox($label, $items, $this->customerTable);	
	}

	/**
	 * @return \App\Components\Form\ImageUpload
	 */
	public function addCountrySelectBox($name, $label)
	{
		return $this[$name] = new CountrySelectBox($label, null, $this->countryTable);
	}
}
