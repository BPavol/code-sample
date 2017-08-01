<?php

namespace App\Components;

/**
 * Viasual component for pagination based on https://github.com/iPublikuj/visual-paginator.
 *
 * @property-read string $perPage
 * @property-read array $offset
 */
class Paginator extends BaseControl
{

	CONST DEFAULT_ITEMS_PER_PAGE = 25;

	private $paginator;

	/** @persistent */
	public $page = 1;

	public function __construct()
	{
		$this->paginator = new \Nette\Utils\Paginator;
	}

	public function set($itemCount, $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE)
	{
		$this->paginator->setItemsPerPage($itemsPerPage);
		$this->paginator->setItemCount($itemCount);
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/../templates/components/paginator.latte');

		$steps = array($this->paginator->page);
		if ($this->paginator->pageCount >= 2) {
			$arr = range(max($this->paginator->firstPage, $this->paginator->page - 3), min($this->paginator->lastPage, $this->paginator->page + 3));
			$count = 4;
			$quotient = ($this->paginator->pageCount - 1) / $count;
			for ($i = 0; $i <= $count; $i++)
				$arr[] = round($quotient * $i) + $this->paginator->firstPage;
			sort($arr);

			$steps = array_values(array_unique($arr));
		}

		$this->template->steps = $steps;

		$this->template->paginator = $this->paginator;

		$this->template->render();
	}

	public function getPerPage()
	{
		return $this->paginator->getItemsPerPage();
	}

	public function getOffset()
	{
		return $this->paginator->getOffset();
	}

	/**
	 * Loads state informations.
	 * @param  array
	 * @return void
	 */
	public function loadState(array $params)
	{
		parent::loadState($params);
		$this->paginator->page = $this->page;
	}

}
