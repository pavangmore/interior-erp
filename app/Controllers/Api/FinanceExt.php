<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Services\LedgerService;

class FinanceExt extends ResourceController {
  protected $format='json';
  public function postInvoiceToLedger($id){
    $db = \Config\Database::connect();
    $inv = $db->table('fin_invoice')->where('id',$id)->get()->getRowArray();
    if(!$inv) return $this->failNotFound();
    $ok = (new LedgerService($db))->postInvoice($inv);
    return $ok ? $this->respond(['posted'=>true]) : $this->fail('Post failed');
  }
  public function postReceiptToLedger($id){
    $db = \Config\Database::connect();
    $rcpt = $db->table('fin_receipt')->where('id',$id)->get()->getRowArray();
    if(!$rcpt) return $this->failNotFound();
    $rcpt['tds'] = (float)($this->request->getGet('tds') ?? 0);
    $ok = (new LedgerService($db))->postReceipt($rcpt);
    return $ok ? $this->respond(['posted'=>true]) : $this->fail('Post failed');
  }
}
