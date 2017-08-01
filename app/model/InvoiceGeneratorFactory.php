<?php

namespace App\Model;

class InvoiceGeneratorFactory{

	/** @var Nette\Application\IPresenter */
	private $presenter;
	
	/** @var \Nette\Application\UI\ITemplateFactory */
	private $templateFactory;
	
	/** @var Entities\IInvoiceFactory */ 
	protected $invoiceFactory;

	public function __construct(
		\Nette\Application\Application $application,
		\Nette\Application\UI\ITemplateFactory $templateFactory,
		Entities\IInvoiceFactory $invoiceFactory
	){
		$this->presenter = $application->getPresenter();		
		$this->templateFactory = $templateFactory;
		$this->invoiceFactory = $invoiceFactory;
	}
	
	protected function createTemplate($templatePath, array $params = [])
	{
		$template = $this->templateFactory->createTemplate();
		$template->getLatte()->addProvider('uiPresenter', $this->presenter);
		$template->getLatte()->addProvider('uiControl', $this->presenter);
		
		return $template->setParameters($params)->setFile($templatePath);
	}

	public function create($id){
		$invoice = $this->invoiceFactory->create($id);
		
		$template = $this->createTemplate(__DIR__.'/../templates/invoice/default.latte', ['invoice' => $invoice]);
		
		$mpdf = new \mPDF();
		$mpdf->SetTitle("Invoice no. {$invoice->id}");
		$mpdf->WriteHTML((string) $template);			
		$mpdf->Output("invoice-{$invoice->id}.pdf", 'I');
		exit;
	}
}	