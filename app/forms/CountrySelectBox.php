<?php

namespace App\Forms;

class CountrySelectBox extends \Nette\Forms\Controls\SelectBox
{
	public function __construct($label = null, array $items = null, \App\Model\Tables\CountryTable $countryTable)
	{			
		parent::__construct($label, $items);

		$this->setItems($countryTable->getTable()->fetchPairs('id', 'name'));
	}
}
