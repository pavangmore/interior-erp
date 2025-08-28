<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ProjectModel;
use App\Models\MilestoneModel;

class Projects extends ResourceController {
  protected $format = 'json';
  public function index(){
    $m = new ProjectModel();
    $q = $this->request->getGet('q');
    $builder = $m->withClient();
    if($q) $builder->like('prj_project.name',$q);
    return $this->respond($builder->orderBy('prj_project.id','DESC')->get(50)->getResult());
  }
  public function create(){
    $data = $this->request->getJSON(true);
    $m = new ProjectModel();
    if(!$m->insert($data)) return $this->failValidationErrors($m->errors());
    return $this->respondCreated(['id'=>$m->getInsertID()]);
  }
  public function show($id){
    $m = new ProjectModel();
    $project = $m->withClient()->where('prj_project.id',$id)->get()->getRow();
    if(!$project) return $this->failNotFound();
    $milestones = (new MilestoneModel())->where('project_id',$id)->orderBy('sort_order')->findAll();
    return $this->respond(['project'=>$project,'milestones'=>$milestones]);
  }
  public function addMilestone($id){
    $data = $this->request->getJSON(true);
    $data['project_id'] = (int)$id;
    $mm = new MilestoneModel();
    if(!$mm->insert($data)) return $this->failValidationErrors($mm->errors());
    return $this->respondCreated();
  }
}
