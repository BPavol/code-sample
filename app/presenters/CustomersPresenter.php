<?php

namespace App\Presenters;

class CustomersPresenter extends BaseProtectedPresenter
{
	/** @var \App\Components\Factories\ICustomerFormFactory @inject */
	public $customerFormFactory;
	
	/** @var \App\Components\Factories\Tables\ICustomerTableFactory @inject */
	public $customerTableFactory;
	
	/** @var \App\Model\Tables\CustomerTable @inject */
	public $customerTable;
	
	/** @var \App\Model\Entities\ICustomerFactory @inject */
	public $customerFactory;
	
	/** @var \App\Components\Factories\Tables\IInvoiceTableFactory @inject */
	public $invoiceTableFactory;
	
	/** @var \App\Model\Tables\InvoiceTable @inject */
	public $invoiceTable;
		
	public function renderDefault()
	{
		
	}
	
	public function renderAdd()
	{
		
	}
	
	public function renderEdit($id)
	{
		if (!$id) {
			throw new \Nette\Application\BadRequestException('', 404);
		}
		
		$this->template->customer = $this->customerFactory->create($id);
	}

	/**
	 * Form for adding and editing customers
	 * @return \App\Components\CustomerForm
	 */
	protected function createComponentCustomerForm()
	{
		return $this->customerFormFactory->create($this->getParam('id'));
	}
	
	protected function createComponentCustomerTable()
	{
		$selection = $this->customerTable->getTable();
		if ($this->fulltext) {
			$selection->where('name LIKE ? OR surname LIKE ? OR email LIKE ?', '%'.$this->fulltext.'%', '%'.$this->fulltext.'%', '%'.$this->fulltext.'%');
		}
		
		return $this->customerTableFactory->create($selection);
	}
	
	protected function createComponentCustomerInvoiceTable()
	{
		$selection = $this->invoiceTable->getTable()->where('customer_id', $this->getParam('id'));		
		return $this->invoiceTableFactory->create($selection);
	}
}
