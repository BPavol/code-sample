<?php

namespace App\Components;

class CustomerForm extends BaseControl
{
	/** @var \App\Forms\IFormFactory */
	private $formFactory;	
		
	/** @var \App\Model\Entities\Customer */
	protected $customer;
	
	public function __construct($id = null, \App\Model\Entities\ICustomerFactory $customerFactory, \App\Forms\IFormFactory $formFactory)
	{
		parent::__construct();

		$this->formFactory = $formFactory;
		$this->customer = $customerFactory->create($id);
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/../templates/components/customerForm.latte');
	}

	protected function createComponentCustomerForm()
	{
		$form = $this->formFactory->create();

		$form->addText('email', 'Email*:')
			->setRequired(true)
			->setAttribute('placeholder', 'Email')
			->setAttribute('class', 'form-control')
			->addRule(\Nette\Application\UI\Form::EMAIL, 'Wrong email address!');

		$form->addText('name', 'Name*:')
			->setRequired(true)
			->setAttribute('placeholder', 'Name')
			->setAttribute('class', 'form-control')
			->addRule(\Nette\Application\UI\Form::MAX_LENGTH, 'Name can contain max. %d characters.', 64);

		$form->addText('surname', 'Surname*:')
			->setRequired(true)
			->setAttribute('placeholder', 'Surname')
			->setAttribute('class', 'form-control')
			->addRule(\Nette\Application\UI\Form::MAX_LENGTH, 'Surname can contain max. %d characters.', 64);

		$form->addCountrySelectBox('country_id', 'Country*:')
			->setRequired(true)
			->setAttribute('class', 'form-control')
			->setDefaultValue(192);

		$form->addText('city', 'City*:')
			->setRequired(true)
			->setAttribute('placeholder', 'City')
			->setAttribute('class', 'form-control')
			->addRule(\Nette\Application\UI\Form::MAX_LENGTH, 'Mesto môže obsahovať najviac %d znakov.', 64);

		$form->addText('postal_code', 'Postal code*:')
			->setRequired(true)
			->setAttribute('placeholder', 'Postal code')
			->setAttribute('class', 'form-control')
			->addFilter(function ($string) {
				return preg_replace('/\s+/', '', $string);
			})->addRule(\Nette\Application\UI\Form::PATTERN, 'PSČ musí mať 5 až 12 číslic', '([0-9]\s*){5,12}');

		$form->addText('company_reg_id', 'Company registration ID*:')
			->setRequired(false)
			->setAttribute('placeholder', 'IČO')
			->setAttribute('class', 'form-control')
			->addFilter(function ($string) {
				return preg_replace('/\s+/', '', $string);
			})->addCondition(\Nette\Application\UI\Form::FILLED)
				->addRule(\Nette\Application\UI\Form::PATTERN, 'IČO in format: 12345679', '([0-9]\s*){8}');
		
		$form->addText('tax_id', 'Tax ID:')
			->setRequired(false)
			->setAttribute('placeholder', 'DIČ')
			->setAttribute('class', 'form-control')
			->addFilter(function ($string) {
				return preg_replace('/\s+/', '', $string);
			})->addCondition(\Nette\Application\UI\Form::FILLED)
				->addRule(\Nette\Application\UI\Form::PATTERN, 'DIČ in format: 1234567895', '([0-9]\s*){10}');
		
		$form->addText('vat_number', 'Vat number:')
			->setRequired(false)
			->setAttribute('placeholder', 'IČ DPH')
			->setAttribute('class', 'form-control')
			->addFilter(function ($string) {
				return strtoupper(preg_replace('/\s+/', '', $string));
			})->addCondition(\Nette\Application\UI\Form::FILLED)
				->addRule(\Nette\Application\UI\Form::PATTERN, 'IČ DPH in format: SK1234567895', '[a-zA-Z]{2}([0-9]\s*){10}');
		
		$form->addText('street', 'Street*:')
			->setRequired(true)
			->setAttribute('placeholder', 'Street')
			->setAttribute('class', 'form-control')
			->addRule(\Nette\Application\UI\Form::MAX_LENGTH, 'Ulica môže obsahovať najviac %d znakov.', 64);

		$form->addSubmit('submit', $this->customer->id ? 'Update' : 'Create')
				->setAttribute('class', 'btn btn-success');

		$form->setDefaults($this->customer->_toArray());
		
		$form->onValidate[] = [$this, 'customerFormValidate'];
		$form->onSuccess[] = [$this, 'customerFormSubmitted'];

		return $form;
	}
	
	public function customerFormValidate(\Nette\Application\UI\Form $form, $values)
	{
		
	}

	public function customerFormSubmitted(\Nette\Application\UI\Form $form, $values)
	{
		$values = $form->getValues();
		$this->customer->setValues($values);
		
		$isNew = !$this->customer->id;
		try {			
			$this->customer->save();
		} catch (\Nette\Database\UniqueConstraintViolationException $e) {
			$form->addError('User with same email already exists!');
			return;
		}
		
		if ($isNew) {
			$this->presenter->flashMessage('New customer was created.');
		} else {
			$this->presenter->flashMessage("Customer \"{$this->customer->email}\" was updated.");
		}		
		$this->presenter->redirect('Customers:edit', [$this->customer->id]);
	}

}
