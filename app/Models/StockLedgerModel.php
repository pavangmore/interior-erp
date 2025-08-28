<?php namespace App\Models; use CodeIgniter\Model;
class StockLedgerModel extends Model {
  protected $table = 'inv_stock_ledger';
  protected $allowedFields = ['material_id','location_id','txn_date','txn_type','qty','rate','ref_table','ref_id'];
}