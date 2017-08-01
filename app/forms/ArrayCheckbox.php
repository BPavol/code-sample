<?php

namespace App\Forms;

class ArrayCheckbox extends \Nette\Forms\Controls\Checkbox
{
	protected $count = 0; //Number of generated controls

	public function __construct($label = NULL)
	{
		parent::__construct($label);
	}

	public function getControl($inputId = null)
	{
		$element = parent::getControl();
		
		if (!isset($inputId)) {
			$element->name .= '[]';
		} else {
			$element->name .= '[' . $inputId . ']';
		}

		if (isset($this->value[$inputId]))
			$element->value = $this->value[$inputId];
		else
			$element->value = '';

		$element->type = $this->type;

		$this->count++;
		return $element;
	}

	/**
	 * @return Nette\Utils\Html
	 */
	public function getControlPart()
    {
		$element = parent::getControlPart();		
		$element->name .= '[]';
		$this->count++;
		
		return $element;
	}
	
	//Set array of values
	public function setValue($value)
	{
		if (!is_array($value)) {
			$this->value = array();
		} else {
			$this->value = $value;
		}

		return $this;
	}

	protected function getHttpData($type, $htmlTail = NULL)
	{
		return parent::getHttpData($type | \Nette\Forms\Form::DATA_KEYS, '[]');
	}

	//Get array of values
	public function getValue()
	{
		if (!is_array($this->value))
			return '';

		return $this->value;
	}

}
