<?php namespace App\Models; use CodeIgniter\Model;
class MilestoneModel extends Model {
  protected $table = 'prj_milestone';
  protected $allowedFields = ['project_id','name','due_date','amount','status','sort_order'];
}