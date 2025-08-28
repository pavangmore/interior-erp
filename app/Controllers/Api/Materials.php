<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MaterialModel;

class Materials extends ResourceController {
  protected $format = 'json';
  public function index(){
    $m = new MaterialModel();
    $q = $this->request->getGet('q');
    $b = $m->select('itm_material.*, itm_uom.code as uom_code')
           ->join('itm_uom','itm_uom.id=itm_material.uom_id','left');
    if($q) $b->like('itm_material.name',$q)->orLike('itm_material.sku',$q);
    return $this->respond($b->orderBy('itm_material.id','DESC')->get(50)->getResult());
  }
  public function create(){
    $data = $this->request->getJSON(true);
    $m = new MaterialModel();
    if(!$m->insert($data)) return $this->failValidationErrors($m->errors());
    return $this->respondCreated(['id'=>$m->getInsertID()]);
  }
}
