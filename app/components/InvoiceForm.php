<?php

namespace App\Components;

class InvoiceForm extends BaseControl
{
	/** @var \App\Forms\IFormFactory */
	private $formFactory;	
		
	/** @var \App\Model\Entities\Invoice */
	protected $invoice;
	
	public function __construct($id = null, \App\Model\Entities\IInvoiceFactory $invoiceFactory, \App\Forms\IFormFactory $formFactory)
	{
		parent::__construct();

		$this->formFactory = $formFactory;
		$this->invoice = $invoiceFactory->create($id);
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/../templates/components/invoiceForm.latte');
	}

	protected function createComponentInvoiceForm()
	{
		$form = $this->formFactory->create();

		$form->addCustomerSelectBox('customer_id', 'Customer*:')
			->setRequired(true)
			->setPrompt('Select customer please...')
			->setAttribute('placeholder', 'Name')
			->setAttribute('class', 'form-control');
		
		$form->addText('name', 'Name*:')
			->setRequired(true)
			->setAttribute('placeholder', 'Name')
			->setAttribute('class', 'form-control')
			->addRule(\Nette\Application\UI\Form::MAX_LENGTH, 'Name can contain max. %d characters.', 64);

		$form->addTextArea('description', 'Description*:')
			->setRequired(true)
			->setAttribute('placeholder', 'Description')
			->setAttribute('class', 'form-control')
			->addRule(\Nette\Application\UI\Form::MAX_LENGTH, 'Surname can contain max. %d characters.', 1024);

		$form->addText('price', 'Price*:')
			->setRequired(true)
			->setAttribute('placeholder', 'Price')
			->setAttribute('class', 'form-control')
			->addRule(\Nette\Application\UI\Form::FLOAT, 'Price must be float number.');

		$form->addSubmit('submit', $this->invoice->id ? 'Update' : 'Create')
				->setAttribute('class', 'btn btn-success');

		$form->setDefaults($this->invoice->_toArray());
		
		$form->onValidate[] = [$this, 'invoiceFormValidate'];
		$form->onSuccess[] = [$this, 'invoiceFormSubmitted'];

		return $form;
	}
	
	public function invoiceFormValidate(\Nette\Application\UI\Form $form, $values)
	{
		
	}

	public function invoiceFormSubmitted(\Nette\Application\UI\Form $form, $values)
	{
		$values = $form->getValues();
		$this->invoice->setValues($values);
		
		$isNew = !$this->invoice->id;
		try {			
			$this->invoice->save();
		} catch (\Exception $e) {
			$form->addError($e->getMessage());
			return;
		}
		
		if ($isNew) {
			$this->presenter->flashMessage('New invoice was created.');
		} else {
			$this->presenter->flashMessage("Invoice \"{$this->invoice->id}\" was updated.");
		}		
		$this->presenter->redirect('Invoices:edit', [$this->invoice->id]);
	}

}
