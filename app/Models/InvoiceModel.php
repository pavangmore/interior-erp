<?php namespace App\Models; use CodeIgniter\Model;
class InvoiceModel extends Model {
  protected $table = 'fin_invoice';
  protected $allowedFields = ['project_id','client_id','invoice_no','invoice_date','milestone_id','taxable_value','cgst','sgst','igst','tds','grand_total','status'];
}