<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ClientModel;

class Clients extends ResourceController {
  protected $format = 'json';
  public function index(){
    $m = new ClientModel();
    $q = $this->request->getGet('q');
    $b = $m->builder();
    if($q){ $b->like('name',$q)->orLike('email',$q); }
    return $this->respond($b->orderBy('id','DESC')->get(50)->getResult());
  }
  public function create(){
    $data = $this->request->getJSON(true);
    $m = new ClientModel();
    if(!$m->insert($data)) return $this->failValidationErrors($m->errors());
    return $this->respondCreated(['id'=>$m->getInsertID()]);
  }
}
