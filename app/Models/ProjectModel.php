<?php namespace App\Models; use CodeIgniter\Model;
class ProjectModel extends Model {
  protected $table = 'prj_project';
  protected $allowedFields = ['client_id','code','name','start_date','end_date','status','budget','retention_pct'];
  public function withClient(){
    return $this->db->table('prj_project')
      ->select('prj_project.*, org_client.name as client_name')
      ->join('org_client','org_client.id=prj_project.client_id','left');
  }
}