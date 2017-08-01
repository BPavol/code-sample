<?php

namespace App\Presenters;

class SignPresenter extends BasePresenter
{
	/** @var \App\Components\Factories\ISignInFormFactory @inject */
	public $signInFormFactory;

	/**
	 * Sign-in form factory.
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		return $this->signInFormFactory->create(function () {
			$this->redirect('Homepage:');
		});
	}

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->redirect('Homepage:');
	}
}
