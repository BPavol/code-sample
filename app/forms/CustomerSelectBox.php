<?php

namespace App\Forms;

/**
 * Customer select box based on Select2 plugin with AJAX support
 */
class CustomerSelectBox extends \Nette\Forms\Controls\SelectBox
{
	/** @var \App\Model\Tables\CustomerTable */
	private $customerTable;

	public function __construct($label = null, array $items = null, \App\Model\Tables\CustomerTable $customerTable)
	{		
		$this->customerTable = $customerTable;
		
		parent::__construct($label, $items);
		
		$this->monitor('\Nette\Application\UI\Presenter');
		
		$this->checkAllowedValues = false;
	}
	
	protected function attached($parent)
	{
		parent::attached($parent);
		
		if ($parent instanceof \Nette\Application\UI\Presenter) {
			$this->setAttribute('data-ajax--url', $parent->link('Autocomplete:customer'));	
		}
	}
	
	/**
	 * Generates control's HTML element.
	 * @return Nette\Utils\Html
	 */
	public function getControl()
	{
		$control = parent::getControl();
		$control->setAttribute('class', $control->class . ' select2-select-ajax');
		
		// Select2: placeholder must be filled(empty string is enought) for allowClear=true
		$control->setAttribute('data-placeholder', $this->getPrompt()?: '');
		
		if (!$this->isRequired()) {
			$control->setAttribute('data-allow-clear', true);
		}
		
		return $control;
	}
	
	/**
	 * Sets selected item (by key).
	 * @param  string|int
	 * @return static
	 * @internal
	 */
	public function setValue($value)
	{
		parent::setValue($value);
		
		// Add existing item to selectbox
		$this->setItems(
			$this->customerTable->getTable()->where('id', $value)
				->select('id, CONCAT(name, " ", surname, "(", email, ")") AS name_surname_email')
				->fetchPairs('id', 'name_surname_email')
		);
		
		return $this;
	}
	
	/**
	 * Returns selected key.
	 * @return string|int
	 */
	public function getValue()
	{
		return $this->customerTable->getTable()->where('id', $this->value)->count('*') ? $this->value : null;
	}
}
