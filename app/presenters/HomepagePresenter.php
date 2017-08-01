<?php

namespace App\Presenters;

class HomepagePresenter extends BaseProtectedPresenter
{	
	/** @var \App\Model\Tables\CustomerTable @inject */
	public $customerTable;
	
	/** @var \App\Model\Tables\InvoiceTable @inject */
	public $invoiceTable;
	
	public function renderDefault()
	{
		$this->template->customersCount = $this->customerTable->getTable()->count('*');
		$this->template->invoicesCount = $this->invoiceTable->getTable()->count('*');
		$this->template->lastCustomer = $this->customerTable->getTable()->order('id DESC')->limit(1)->fetch();
		$this->template->lastInvoice = $this->invoiceTable->getTable()->order('id DESC')->limit(1)->fetch();
	}
}
