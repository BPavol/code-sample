<?php

namespace App\Components\Tables;

/**
 * Data grid for invoices
 */
class InvoiceTable extends BaseTable
{					
	/** @var array Must be filled in child class with collumns available for order */
	protected $allowed_orders = [
		'id',
		'name',
		'price'
	];

	public function __construct(\Nette\Database\Table\Selection $selection, \App\Forms\IFormFactory $formFactory)
	{
		parent::__construct($selection, $formFactory);
		
		//Add callback for mass selection
		$this->onMassSelectionProcess[] = [$this, 'onMassSelectionProcess'];
	}
	
	public function render(){		
		$this->template->rowsQuery = $this->getPreparedQuery();
		$this->template->rowsCount = $this->rowsCount;
		
		$this->template->render(__DIR__ . '/../../templates/components/tables/invoiceTable.latte');
	}
	
	public function onMassSelectionProcess($removeIds)
	{		
		$affectedRows = $this->selection->where(['id' => $removeIds])->delete();		
		if ($removeIds) {
			$this->presenter->flashMessage('Selected items(' . $affectedRows . ') with IDs(' . implode(', ', $removeIds) . ') was removed!');
		} else {
			$this->presenter->flashMessage('Select something for deletion first.');
		}		
		
		$this->redirect('this');
	}
}
