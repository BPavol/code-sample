<?php

namespace App\Components\Tables;

/**
 * Base class for data grids
 */
abstract class BaseTable extends \App\Components\BaseControl
{			
	/** @persistent */
	public $order = null;
	
	/** @persistent */
	public $desc = false;
	
	/** @var array Must be filled in child class with collumns available for order */
	protected $allowed_orders = [];
	
	/** @var array Column names that should be visible in table */
	protected $columns = [];

	/** @var int Rows per page */
	protected $perPage = 15;
	
	/** @var int Total rows count */
	protected $rowsCount;
	
	/** @var \Nette\Database\Table\Selection Rows in table */
	protected $selection;
	
	/** @var \App\Components\Paginator */
	protected $paginator;

	/** @var callable[]  function (array $ids); Occurs when the form is submitted, successfully validated and IDs are prepared */
	public $onMassSelectionProcess;
	
	/** @var \App\Forms\IFormFactory */
	private $formFactory;	
	
	public function __construct(\Nette\Database\Table\Selection $selection, \App\Forms\IFormFactory $formFactory)
	{
		parent::__construct();

		$this->selection = $selection;
		$this->formFactory = $formFactory;
	}
	
	public function setPerPage($perPage)
	{
		$this->perPage = $perPage;
		
		return $this;
	}
	
	/**
	 * Override default visible columns set.
	 * 
	 * @param array $columns
	 */
	public function setColumns(array $columns)
	{
		$this->columns = $columns;
		
		return $this;
	}
	
	protected function getPreparedQuery()
	{		
		$paginator = $this['paginator'];
		$this->rowsCount = $this->selection->count('*');
		$paginator->set($this->rowsCount, $this->perPage);	
		$this->selection->limit($paginator->perPage, $paginator->offset);

		if ($this->order && in_array($this->order, $this->allowed_orders)) {		
			$this->selection->order($this->order.' '.($this->desc ? 'DESC' : 'ASC'));
		}
		
		return $this->selection;
	}

	public function handleOrder($order = null)
	{
		if (!in_array($order, $this->allowed_orders))
			$this->redirect('this');

		if ($this->order == $order)
			$this->desc = !$this->desc;
		else
			$this->desc = false;

		$this->order = $order;
		//$this->redirect('this');
	}
	
	protected function createComponentMassSelectionForm()
	{
		$form = $this->formFactory->create();

		$form->addArrayCheckbox('id', 'Select')
			->setAttribute('class', 'massSelectionSelectbox');

		$form->addSubmit('delete', 'Delete selected')
				->setAttribute('class', 'btn btn-danger');

		$form->onSuccess[] = [$this, 'massSelectionFormSubmitted'];

		return $form;
	}

	public function massSelectionFormSubmitted($form)
	{
		$values = $form->getValues();

		$ids = [];
		foreach ($values['id'] as $key => $id) {
			if ($id) {
				$ids[] = $id;
			}
		}
		
		if (isset($this->onMassSelectionProcess)) {
			if (!is_array($this->onMassSelectionProcess) && !$this->onMassSelectionProcess instanceof \Traversable) {
				throw new \Nette\UnexpectedValueException('Property BaseTable::$onMassSelectionProcess must be array or Traversable, '.gettype($this->onMassSelectionProcess).' given.');
			}
			foreach ($this->onMassSelectionProcess as $handler) {
				\Nette\Utils\Callback::invoke($handler, $ids);
			}
		}
	}
}
