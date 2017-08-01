<?php

namespace App\Presenters;

use Nette;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var \WebLoader\Nette\LoaderFactory @inject */
	public $webLoader;

	/** @var \App\Components\Factories\IPaginatorFactory @inject */
    public $paginatorFactory;
	
	/** @var \App\Forms\FulltextFilterFormFactory @inject */
	public $fulltextFilterFormFactory;
	
	/** @var string @persistent */
	public $fulltext;
	
	/** @return CssLoader */
	protected function createComponentCss()
	{
		return $this->webLoader->createCssLoader('admin');
	}

	/** @return JavaScriptLoader */
	protected function createComponentJs()
	{
		return $this->webLoader->createJavaScriptLoader('admin');
	}
	
	protected function createComponentPaginator()
	{		
		return $this->paginatorFactory->create();
	}
	
	protected function createComponentFulltextFilterForm()
	{
		return $this->fulltextFilterFormFactory->create(function (\Nette\Application\UI\Form $form, $values) {
			$this->redirect('this', ['fulltext' => $values->fulltext]);
		})->setDefaults(['fulltext' => $this->fulltext]);
	}
}
