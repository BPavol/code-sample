<?php

namespace App\Presenters;

class AutocompletePresenter extends BaseProtectedPresenter
{	
	/** @var \App\Model\Tables\CustomerTable @inject */
	public $customerTable;
	
	public function actionCustomer(){
		$query = $this->getParameter('q');
		$wildcardEscapedQuery = \App\Model\Tables\Table::escape_wildcards($query);

		$selection = $this->customerTable->getTable()->where(
			'name LIKE ? ESCAPE \'=\' OR surname LIKE ? ESCAPE \'=\' OR email LIKE ? ESCAPE \'=\'', 
			'%'.$wildcardEscapedQuery.'%', '%'.$wildcardEscapedQuery.'%', '%'.$wildcardEscapedQuery.'%'
		)->select('id, CONCAT(name, " ", surname, "(", email, ")") AS name_surname_email')->limit(10);

		$this->sendResponse(new \Nette\Application\Responses\JsonResponse($selection->fetchPairs('id', 'name_surname_email')));
	}
}
