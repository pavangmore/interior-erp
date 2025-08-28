<?php
namespace App\Database\Migrations; use CodeIgniter\Database\Migration;
class FinTaxMasters extends Migration {
  public function up(){
    $this->db->query("CREATE TABLE IF NOT EXISTS fin_state (
      code CHAR(2) PRIMARY KEY, name VARCHAR(64) NOT NULL)");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_tax_code (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      code VARCHAR(20) UNIQUE,
      description VARCHAR(190),
      kind ENUM('GST_OUTPUT','GST_INPUT','IGST_OUTPUT','IGST_INPUT','CGST_OUTPUT','CGST_INPUT','SGST_OUTPUT','SGST_INPUT','TDS_PAYABLE','TDS_RECEIVABLE') NOT NULL,
      rate DECIMAL(6,3) NOT NULL,
      section VARCHAR(16) NULL,
      sac_hsn VARCHAR(16) NULL,
      active TINYINT(1) DEFAULT 1)");
  }
  public function down(){
    $this->db->query('DROP TABLE IF EXISTS fin_tax_code');
    $this->db->query('DROP TABLE IF EXISTS fin_state');
  }
}
