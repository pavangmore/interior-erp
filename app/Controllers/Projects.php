<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProjectModel;
use App\Models\MilestoneModel;

class Projects extends Controller {
  public function listPage(){
    return view('projects_list');
  }
  public function objectPage($id){
    $m = new ProjectModel();
    $project = $m->withClient()->where('prj_project.id',$id)->get()->getRow();
    $milestones = (new MilestoneModel())->where('project_id',$id)->orderBy('sort_order')->findAll();
    return view('project_object', ['project'=>$project,'milestones'=>$milestones]);
  }
}
