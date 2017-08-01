<?php

namespace App\Forms;

class FulltextFilterFormFactory
{
	/** @var \App\Forms\IFormFactory */
	private $formFactory;	
			
	public function __construct(\App\Forms\IFormFactory $formFactory)
	{
		$this->formFactory = $formFactory;
	}

	public function create(callable $onSuccess)
	{
		$form = $this->formFactory->create();

		$form->addText('fulltext', 'Search:')
			->setRequired(false)
			->setAttribute('placeholder', 'Search...')
			->setAttribute('class', 'form-control')
			->addCondition(\Nette\Application\UI\Form::FILLED) // Allow filter clear
				->addRule(\Nette\Application\UI\Form::MIN_LENGTH, 'Input is too short(min. %d characters).', 3);
 
		$form->addSubmit('submit', 'Search')
				->setAttribute('class', 'btn btn-success');

		$form->onSuccess[] = $onSuccess;

		return $form;
	}
}
