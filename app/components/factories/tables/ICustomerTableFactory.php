<?php

namespace App\Components\Factories\Tables;

interface ICustomerTableFactory
{
	/**
	 * @param \Nette\Database\Table\Selection $selection
     * @return \App\Components\Tables\CustomerTable
     */
    public function create(\Nette\Database\Table\Selection $selection);
}