<?php namespace App\Models; use CodeIgniter\Model;
class PoItemModel extends Model {
  protected $table = 'proc_po_item';
  protected $allowedFields = ['po_id','material_id','qty','rate','gst_pct'];
}