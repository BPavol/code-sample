<?php

namespace App\Components;

abstract class BaseControl extends \Nette\Application\UI\Control
{
	/* Components */
	protected function createComponentPaginator()
	{		
		return $this->presenter->paginatorFactory->create();
	}
}
