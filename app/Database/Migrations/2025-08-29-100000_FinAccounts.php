<?php
namespace App\Database\Migrations; use CodeIgniter\Database\Migration;
class FinAccounts extends Migration {
  public function up(){
    $this->db->query("CREATE TABLE IF NOT EXISTS fin_account_type (
      id TINYINT PRIMARY KEY,
      code VARCHAR(16) UNIQUE,
      name VARCHAR(64) NOT NULL)");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_account (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      code VARCHAR(32) UNIQUE,
      name VARCHAR(190) NOT NULL,
      type_id TINYINT NOT NULL,
      parent_id BIGINT NULL,
      is_control TINYINT(1) DEFAULT 0,
      FOREIGN KEY (type_id) REFERENCES fin_account_type(id))");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_opening_balance (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      account_id BIGINT NOT NULL,
      fiscal_year VARCHAR(9) NOT NULL,
      debit DECIMAL(16,2) DEFAULT 0,
      credit DECIMAL(16,2) DEFAULT 0,
      UNIQUE(account_id,fiscal_year),
      FOREIGN KEY (account_id) REFERENCES fin_account(id))");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_journal (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      jv_no VARCHAR(30) UNIQUE,
      jv_date DATE NOT NULL,
      narration VARCHAR(255),
      project_id BIGINT NULL,
      ref_table VARCHAR(50), ref_id BIGINT,
      created_by BIGINT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_journal_line (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      journal_id BIGINT NOT NULL,
      line_no INT DEFAULT 1,
      account_id BIGINT NOT NULL,
      party_type ENUM('customer','vendor','other') NULL,
      party_id BIGINT NULL,
      debit DECIMAL(16,2) DEFAULT 0,
      credit DECIMAL(16,2) DEFAULT 0,
      cost_center VARCHAR(64) NULL,
      project_id BIGINT NULL,
      FOREIGN KEY (journal_id) REFERENCES fin_journal(id) ON DELETE CASCADE,
      FOREIGN KEY (account_id) REFERENCES fin_account(id))");
  }
  public function down(){
    $this->db->query('DROP TABLE IF EXISTS fin_journal_line');
    $this->db->query('DROP TABLE IF EXISTS fin_journal');
    $this->db->query('DROP TABLE IF EXISTS fin_opening_balance');
    $this->db->query('DROP TABLE IF EXISTS fin_account');
    $this->db->query('DROP TABLE IF EXISTS fin_account_type');
  }
}
