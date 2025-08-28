<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class ProcurementFinance extends Migration {
  public function up(){
    $this->db->query("CREATE TABLE IF NOT EXISTS proc_vendor (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      legal_name VARCHAR(190) NOT NULL,
      gstin VARCHAR(20), pan VARCHAR(20),
      contact_name VARCHAR(190), email VARCHAR(190), phone VARCHAR(30))");

    $this->db->query("CREATE TABLE IF NOT EXISTS proc_po (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      vendor_id BIGINT NOT NULL,
      project_id BIGINT,
      po_number VARCHAR(50) UNIQUE,
      po_date DATE NOT NULL,
      status ENUM('draft','approved','partly_received','closed','cancelled') DEFAULT 'draft',
      FOREIGN KEY (vendor_id) REFERENCES proc_vendor(id))");

    $this->db->query("CREATE TABLE IF NOT EXISTS proc_po_item (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      po_id BIGINT NOT NULL,
      material_id BIGINT NOT NULL,
      qty DECIMAL(14,3) NOT NULL,
      rate DECIMAL(14,3) NOT NULL,
      gst_pct DECIMAL(5,2) DEFAULT 18.00,
      FOREIGN KEY (po_id) REFERENCES proc_po(id),
      FOREIGN KEY (material_id) REFERENCES itm_material(id))");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_invoice (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      project_id BIGINT NOT NULL,
      client_id BIGINT NOT NULL,
      invoice_no VARCHAR(50) UNIQUE,
      invoice_date DATE NOT NULL,
      milestone_id BIGINT,
      taxable_value DECIMAL(14,2) NOT NULL,
      cgst DECIMAL(14,2) DEFAULT 0, sgst DECIMAL(14,2) DEFAULT 0, igst DECIMAL(14,2) DEFAULT 0,
      tds DECIMAL(14,2) DEFAULT 0,
      grand_total DECIMAL(14,2) NOT NULL,
      status ENUM('draft','issued','paid','partly_paid','cancelled') DEFAULT 'draft')");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_receipt (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      invoice_id BIGINT NOT NULL,
      receipt_no VARCHAR(50) UNIQUE,
      receipt_date DATE NOT NULL,
      amount DECIMAL(14,2) NOT NULL,
      mode ENUM('bank','cash','upi','card','other') DEFAULT 'bank',
      FOREIGN KEY (invoice_id) REFERENCES fin_invoice(id))");
  }
  public function down(){
    $this->db->query('DROP TABLE IF EXISTS fin_receipt');
    $this->db->query('DROP TABLE IF EXISTS fin_invoice');
    $this->db->query('DROP TABLE IF EXISTS proc_po_item');
    $this->db->query('DROP TABLE IF EXISTS proc_po');
    $this->db->query('DROP TABLE IF EXISTS proc_vendor');
  }
}
