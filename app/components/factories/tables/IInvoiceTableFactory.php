<?php

namespace App\Components\Factories\Tables;

interface IInvoiceTableFactory
{
	/**
	 * @param \Nette\Database\Table\Selection $selection
     * @return \App\Components\Tables\InvoiceTable
     */
    public function create(\Nette\Database\Table\Selection $selection);
}