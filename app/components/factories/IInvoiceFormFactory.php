<?php

namespace App\Components\Factories;

interface IInvoiceFormFactory
{
	/**
	 * @param int|null $id
     * @return \App\Components\InvoiceForm
     */
    public function create($id = null);
}