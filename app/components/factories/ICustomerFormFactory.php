<?php

namespace App\Components\Factories;

interface ICustomerFormFactory
{
	/**
	 * @param int|null $id
     * @return \App\Components\CustomerForm
     */
    public function create($id = null);
}