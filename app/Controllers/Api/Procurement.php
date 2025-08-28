<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PoModel;
use App\Models\PoItemModel;

class Procurement extends ResourceController {
  protected $format = 'json';
  public function createPO(){
    $data = $this->request->getJSON(true);
    $po = new PoModel();
    $pi = new PoItemModel();
    $items = $data['items'] ?? [];
    unset($data['items']);
    if(!$po->insert($data)) return $this->failValidationErrors($po->errors());
    $poId = $po->getInsertID();
    foreach($items as $it){ $it['po_id']=$poId; $pi->insert($it); }
    return $this->respondCreated(['po_id'=>$poId]);
  }
}
