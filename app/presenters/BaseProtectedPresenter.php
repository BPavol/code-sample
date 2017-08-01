<?php

namespace App\Presenters;

abstract class BaseProtectedPresenter extends \App\Presenters\BasePresenter
{				
	public function startup(){
		parent::startup();

		
		if (!$this->user->isLoggedIn()) {
			$this->redirect(':Sign:');
		}
	}	
}
