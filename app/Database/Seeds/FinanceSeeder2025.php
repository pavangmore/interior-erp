<?php namespace App\Database\Seeds; use CodeIgniter\Database\Seeder;
class FinanceSeeder2025 extends Seeder {
  public function run(){
    // Account types
    $this->db->table('fin_account_type')->insertBatch([
      ['id'=>1,'code'=>'AST','name'=>'Assets'],
      ['id'=>2,'code'=>'LIA','name'=>'Liabilities'],
      ['id'=>3,'code'=>'EQT','name'=>'Equity'],
      ['id'=>4,'code'=>'REV','name'=>'Revenue'],
      ['id'=>5,'code'=>'EXP','name'=>'Expenses'],
    ]);

    // Minimal CoA
    $this->db->table('fin_account')->insertBatch([
      ['code'=>'1000','name'=>'Bank', 'type_id'=>1],
      ['code'=>'1100','name'=>'Accounts Receivable', 'type_id'=>1, 'is_control'=>1],
      ['code'=>'1200','name'=>'Input CGST', 'type_id'=>1],
      ['code'=>'1210','name'=>'Input SGST', 'type_id'=>1],
      ['code'=>'1220','name'=>'Input IGST', 'type_id'=>1],

      ['code'=>'2000','name'=>'Accounts Payable', 'type_id'=>2, 'is_control'=>1],
      ['code'=>'2100','name'=>'Output CGST', 'type_id'=>2],
      ['code'=>'2110','name'=>'Output SGST', 'type_id'=>2],
      ['code'=>'2120','name'=>'Output IGST', 'type_id'=>2],
      ['code'=>'2130','name'=>'TDS Payable', 'type_id'=>2],

      ['code'=>'3000','name'=>'Share Capital', 'type_id'=>3],

      ['code'=>'4000','name'=>'Sales/Service Revenue', 'type_id'=>4],

      ['code'=>'5000','name'=>'Purchases/COGS', 'type_id'=>5],
      ['code'=>'5100','name'=>'Subcontract/Contractor Expense', 'type_id'=>5],
      ['code'=>'5200','name'=>'Professional Fees Expense', 'type_id'=>5],
    ]);

    // States (subset)
    $states = [['MH','Maharashtra'],['KA','Karnataka'],['DL','Delhi'],['GJ','Gujarat'],['TN','Tamil Nadu']];
    foreach($states as $s){ $this->db->table('fin_state')->insert(['code'=>$s[0],'name'=>$s[1]]); }

    // Taxes (examples)
    $this->db->table('fin_tax_code')->insertBatch([
      ['code'=>'GST18','description'=>'GST @18% (standard services)','kind'=>'GST_OUTPUT','rate'=>18.00,'sac_hsn'=>'998391'],
      ['code'=>'IGST18','description'=>'IGST @18%','kind'=>'IGST_OUTPUT','rate'=>18.00],
      ['code'=>'CGST9','description'=>'CGST @9%','kind'=>'CGST_OUTPUT','rate'=>9.00],
      ['code'=>'SGST9','description'=>'SGST @9%','kind'=>'SGST_OUTPUT','rate'=>9.00],
      ['code'=>'TDS194C','description'=>'TDS Sec 194C (Contractor)','kind'=>'TDS_PAYABLE','rate'=>2.00,'section'=>'194C'],
      ['code'=>'TDS194J','description'=>'TDS Sec 194J (Professional)','kind'=>'TDS_PAYABLE','rate'=>10.00,'section'=>'194J'],
    ]);
  }
}
