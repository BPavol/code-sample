<?php

namespace App\Components\Factories;

interface ISignInFormFactory
{	
	/**
	 * @param callable $onSuccess
     * @return \App\Components\SignInForm
     */
    public function create(callable $onSuccess);
}