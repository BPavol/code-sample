<?php

namespace App\Model\Entities;

interface ICustomerFactory
{
	/**
	 * @param int|string|null $id
     * @return Customer
     */
    public function create($id = null);
}
