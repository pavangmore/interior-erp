<?php namespace App\Database\Seeds; use CodeIgniter\Database\Seeder;
class InitialSeeder extends Seeder {
  public function run(){
    $this->db->table('org_client')->insertBatch([
      ['name'=>'Acme Interiors Pvt Ltd','email'=>'info@acme.in','phone'=>'9123456789'],
      ['name'=>'Nirmiti Design House','email'=>'hello@nirmiti.in']
    ]);
    $this->db->table('itm_uom')->insertBatch([
      ['code'=>'NOS','name'=>'Pieces'],['code'=>'SQFT','name'=>'Square Feet'],['code'=>'RFT','name'=>'Running Feet'],['code'=>'KG','name'=>'Kilogram']
    ]);
    $this->db->table('itm_material')->insertBatch([
      ['sku'=>'PLY19','name'=>'Plywood 19mm BWR','uom_id'=>1,'gst_slab'=>18,'hsn'=>'4412','base_cost'=>75],
      ['sku'=>'LAM1','name'=>'Laminate 1.0mm','uom_id'=>1,'gst_slab'=>18,'hsn'=>'3921','base_cost'=>450]
    ]);
    $this->db->table('prj_project')->insert([
      'client_id'=>1,'code'=>'PJT-0001','name'=>'3BHK – Kothrud','status'=>'planning','budget'=>1200000
    ]);
    $this->db->table('prj_milestone')->insertBatch([
      ['project_id'=>1,'name'=>'Advance 10%','due_date'=>date('Y-m-d'),'amount'=>120000,'status'=>'planned','sort_order'=>1],
      ['project_id'=>1,'name'=>'Design Signoff','due_date'=>date('Y-m-d', strtotime('+10 days')),'amount'=>180000,'status'=>'planned','sort_order'=>2]
    ]);
  }
}
