<?php
namespace App\Database\Migrations; use CodeIgniter\Database\Migration;
class FinViews extends Migration {
  public function up(){
    $this->db->query("CREATE OR REPLACE VIEW vw_trial_balance AS
      SELECT a.id account_id, a.code, a.name, at.name type_name,
             COALESCE(SUM(jl.debit),0) - COALESCE(SUM(jl.credit),0) AS closing,
             COALESCE(SUM(jl.debit),0) AS total_debit, COALESCE(SUM(jl.credit),0) AS total_credit
      FROM fin_account a
      JOIN fin_account_type at ON at.id=a.type_id
      LEFT JOIN fin_journal_line jl ON jl.account_id=a.id
      GROUP BY a.id, a.code, a.name, at.name");

    $this->db->query("CREATE OR REPLACE VIEW vw_profit_loss AS
      SELECT 'Revenue' section, a.name account, COALESCE(SUM(jl.credit-jl.debit),0) amount
        FROM fin_account a
        JOIN fin_account_type at ON at.id=a.type_id AND at.code='REV'
        LEFT JOIN fin_journal_line jl ON jl.account_id=a.id
      GROUP BY a.id
      UNION ALL
      SELECT 'Expense', a.name, COALESCE(SUM(jl.debit-jl.credit),0)
        FROM fin_account a
        JOIN fin_account_type at ON at.id=a.type_id AND at.code='EXP'
        LEFT JOIN fin_journal_line jl ON jl.account_id=a.id
      GROUP BY a.id");

    $this->db->query("CREATE OR REPLACE VIEW vw_balance_sheet AS
      SELECT at.code type_code, at.name type_name, a.name account,
             COALESCE(SUM(jl.debit - jl.credit),0) AS amount
      FROM fin_account a
      JOIN fin_account_type at ON at.id=a.type_id AND at.code IN ('AST','LIA','EQT')
      LEFT JOIN fin_journal_line jl ON jl.account_id=a.id
      GROUP BY at.code, at.name, a.name");

    $this->db->query("CREATE OR REPLACE VIEW vw_gstr1_b2b AS
      SELECT c.gstin AS receiver_gstin, i.invoice_no, i.invoice_date,
             CASE WHEN c.gstin IS NULL OR c.gstin='' THEN 'URP' ELSE c.gstin END AS receiver,
             i.taxable_value,
             (i.cgst + i.sgst) AS intrastate_tax, i.igst AS interstate_tax
      FROM fin_invoice i
      JOIN org_client c ON c.id=i.client_id
      WHERE i.status IN ('issued','paid','partly_paid')");

    $this->db->query("CREATE OR REPLACE VIEW vw_gstr3b_summary AS
      SELECT DATE_FORMAT(invoice_date,'%Y-%m') tax_period,
             SUM(taxable_value) taxable,
             SUM(cgst) cgst, SUM(sgst) sgst, SUM(igst) igst,
             SUM(grand_total) outward
      FROM fin_invoice
      WHERE status IN ('issued','paid','partly_paid')
      GROUP BY DATE_FORMAT(invoice_date,'%Y-%m')");
  }
  public function down(){
    $this->db->query('DROP VIEW IF EXISTS vw_gstr3b_summary');
    $this->db->query('DROP VIEW IF EXISTS vw_gstr1_b2b');
    $this->db->query('DROP VIEW IF EXISTS vw_balance_sheet');
    $this->db->query('DROP VIEW IF EXISTS vw_profit_loss');
    $this->db->query('DROP VIEW IF EXISTS vw_trial_balance');
  }
}
