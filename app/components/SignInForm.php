<?php

namespace App\Components;


class SignInForm extends BaseControl
{
	/** @var callable */
	private $onSuccess;
	
	/** @var \App\Forms\FormFactory */
	private $formFactory;

	/** @var \Nette\Security\User */
	private $user;
	
	public function __construct(callable $onSuccess, \App\Forms\IFormFactory $formFactory, \Nette\Security\User $user)
	{
		$this->onSuccess = $onSuccess;
		$this->formFactory = $formFactory;
		$this->user = $user;
	}
	
	public function render()
	{
		$this->template->render(__DIR__ . '/../templates/components/signInForm.latte');
	}
	
	/**
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->formFactory->create();
		$form->addText('email', 'Email:')				
			->setRequired('Please enter your email.')
			->setAttribute('placeholder', 'Email')
			->setAttribute('class', 'form-control');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.')
			->setAttribute('placeholder', 'Password')
			->setAttribute('class', 'form-control');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('submit', 'Sign in')
			->setAttribute('class', 'btn btn-lg btn-primary btn-block');

		$form->onSuccess[] = [$this, 'signInFormSubmitted'];
		$form->onSuccess[] = $this->onSuccess;

		return $form;
	}
	
	public function signInFormSubmitted(\Nette\Application\UI\Form $form, $values)
	{
		try {
			$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
			$this->user->login($values->email, $values->password);
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError('The email or password you entered is incorrect.');
			return;
		}
	}
}
