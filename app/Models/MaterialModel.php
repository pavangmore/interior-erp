<?php namespace App\Models; use CodeIgniter\Model;
class MaterialModel extends Model {
  protected $table = 'itm_material';
  protected $allowedFields = ['sku','name','uom_id','gst_slab','hsn','base_cost'];
}