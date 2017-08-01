<?php

namespace App\Model\Entities;

interface IInvoiceFactory
{
	/**
	 * @param int|string|null $id
     * @return Invoice
     */
    public function create($id = null);
}
