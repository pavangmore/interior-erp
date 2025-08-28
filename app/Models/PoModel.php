<?php namespace App\Models; use CodeIgniter\Model;
class PoModel extends Model {
  protected $table = 'proc_po';
  protected $allowedFields = ['vendor_id','project_id','po_number','po_date','status'];
}