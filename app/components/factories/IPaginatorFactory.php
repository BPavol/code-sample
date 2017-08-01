<?php

namespace App\Components\Factories;

interface IPaginatorFactory
{
	/**
     * @return \App\Components\Paginator
     */
    public function create();
}