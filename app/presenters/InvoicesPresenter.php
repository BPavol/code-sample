<?php

namespace App\Presenters;

class InvoicesPresenter extends BaseProtectedPresenter
{
	/** @var \App\Components\Factories\IInvoiceFormFactory @inject */
	public $invoiceFormFactory;
	
	/** @var \App\Components\Factories\Tables\IInvoiceTableFactory @inject */
	public $invoiceTableFactory;
	
	/** @var \App\Model\Tables\InvoiceTable @inject */
	public $invoiceTable;
	
	/** @var \App\Model\Entities\IInvoiceFactory @inject */
	public $invoiceFactory;
	
	/** @var \App\Model\InvoiceGeneratorFactory @inject */
	public $invoiceGeneratorFactory;
		
	public function renderDefault()
	{
		
	}
	
	public function renderAdd()
	{
		
	}
	
	public function renderEdit($id)
	{
		if (!$id || !$this->invoiceTable->getActiveRow($id)) {
			throw new \Nette\Application\BadRequestException('', 404);
		}
		
		$this->template->invoice = $this->invoiceFactory->create($id);
	}
	
	public function actionExport($id)
	{
		if (!$id || !$this->invoiceTable->getActiveRow($id)) {
			throw new \Nette\Application\BadRequestException('', 404);
		}
		
		$this->invoiceGeneratorFactory->create($id);
	}

	/**
	 * Form for adding and editing invoices
	 * @return \App\Components\InvoiceForm
	 */
	protected function createComponentInvoiceForm()
	{
		return $this->invoiceFormFactory->create($this->getParam('id'));
	}
	
	protected function createComponentInvoiceTable()
	{
		$selection = $this->invoiceTable->getTable();
		if ($this->fulltext) {
			$selection->where('name LIKE ? OR description LIKE ?', '%'.$this->fulltext.'%', '%'.$this->fulltext.'%');
		}
		
		return $this->invoiceTableFactory->create($selection);
	}
}
