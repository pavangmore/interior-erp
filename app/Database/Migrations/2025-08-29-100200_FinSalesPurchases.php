<?php
namespace App\Database\Migrations; use CodeIgniter\Database\Migration;
class FinSalesPurchases extends Migration {
  public function up(){
    $this->db->query("CREATE TABLE IF NOT EXISTS fin_invoice_item (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      invoice_id BIGINT NOT NULL,
      description VARCHAR(255),
      hsn_sac VARCHAR(16),
      qty DECIMAL(14,3) DEFAULT 1,
      uom VARCHAR(16),
      rate DECIMAL(14,2) NOT NULL,
      taxable_value DECIMAL(14,2) NOT NULL,
      gst_rate DECIMAL(5,2) DEFAULT 18.00,
      cgst DECIMAL(14,2) DEFAULT 0, sgst DECIMAL(14,2) DEFAULT 0, igst DECIMAL(14,2) DEFAULT 0,
      FOREIGN KEY (invoice_id) REFERENCES fin_invoice(id) ON DELETE CASCADE)");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_vendor_bill (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      vendor_id BIGINT NOT NULL,
      bill_no VARCHAR(50), bill_date DATE NOT NULL,
      ref_po_id BIGINT NULL,
      taxable_value DECIMAL(14,2) NOT NULL,
      cgst DECIMAL(14,2) DEFAULT 0, sgst DECIMAL(14,2) DEFAULT 0, igst DECIMAL(14,2) DEFAULT 0,
      grand_total DECIMAL(14,2) NOT NULL,
      status ENUM('draft','booked','paid','partly_paid','cancelled') DEFAULT 'draft')");

    $this->db->query("CREATE TABLE IF NOT EXISTS fin_vendor_bill_item (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      bill_id BIGINT NOT NULL,
      description VARCHAR(255), hsn_sac VARCHAR(16),
      qty DECIMAL(14,3) DEFAULT 1, uom VARCHAR(16),
      rate DECIMAL(14,2) NOT NULL, taxable_value DECIMAL(14,2) NOT NULL,
      gst_rate DECIMAL(5,2) DEFAULT 18.00,
      cgst DECIMAL(14,2) DEFAULT 0, sgst DECIMAL(14,2) DEFAULT 0, igst DECIMAL(14,2) DEFAULT 0,
      FOREIGN KEY (bill_id) REFERENCES fin_vendor_bill(id) ON DELETE CASCADE)");
  }
  public function down(){
    $this->db->query('DROP TABLE IF EXISTS fin_vendor_bill_item');
    $this->db->query('DROP TABLE IF EXISTS fin_vendor_bill');
    $this->db->query('DROP TABLE IF EXISTS fin_invoice_item');
  }
}
