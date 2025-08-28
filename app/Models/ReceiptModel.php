<?php namespace App\Models; use CodeIgniter\Model;
class ReceiptModel extends Model {
  protected $table = 'fin_receipt';
  protected $allowedFields = ['invoice_id','receipt_no','receipt_date','amount','mode'];
}