<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\StockLedgerModel;

class Inventory extends ResourceController {
  protected $format = 'json';
  public function grn(){
    $data = $this->request->getJSON(true);
    // expects: material_id, location_id, qty, rate, ref_table, ref_id
    $data['txn_type'] = 'GRN';
    $m = new StockLedgerModel();
    if(!$m->insert($data)) return $this->failValidationErrors($m->errors());
    return $this->respondCreated();
  }
}
