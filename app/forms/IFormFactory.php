<?php

namespace App\Forms;

interface IFormFactory
{
	/**
	 * @param \Nette\ComponentModel\IContainer $parent
	 * @param string|null $name
     * @return \App\Forms\Form
     */
    public function create(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL);
}
