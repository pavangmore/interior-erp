<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\InvoiceModel;
use App\Models\ReceiptModel;

class Finance extends ResourceController {
  protected $format = 'json';
  public function createInvoice(){
    $data = $this->request->getJSON(true);
    $m = new InvoiceModel();
    if(!$m->insert($data)) return $this->failValidationErrors($m->errors());
    return $this->respondCreated(['invoice_id'=>$m->getInsertID()]);
  }
  public function createReceipt(){
    $data = $this->request->getJSON(true);
    $m = new ReceiptModel();
    if(!$m->insert($data)) return $this->failValidationErrors($m->errors());
    return $this->respondCreated(['receipt_id'=>$m->getInsertID()]);
  }
}
