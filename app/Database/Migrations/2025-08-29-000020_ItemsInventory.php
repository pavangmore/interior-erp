<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class ItemsInventory extends Migration {
  public function up(){
    $this->db->query("CREATE TABLE IF NOT EXISTS itm_uom (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      code VARCHAR(16) UNIQUE NOT NULL,
      name VARCHAR(64) NOT NULL)");

    $this->db->query("CREATE TABLE IF NOT EXISTS itm_material (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      sku VARCHAR(64) UNIQUE,
      name VARCHAR(190) NOT NULL,
      uom_id BIGINT NOT NULL,
      gst_slab DECIMAL(5,2) DEFAULT 18.00,
      hsn VARCHAR(16), base_cost DECIMAL(14,2) DEFAULT 0,
      FOREIGN KEY (uom_id) REFERENCES itm_uom(id))");

    $this->db->query("CREATE TABLE IF NOT EXISTS inv_location (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      code VARCHAR(50) UNIQUE,
      name VARCHAR(190) NOT NULL,
      site_id BIGINT NULL)");

    $this->db->query("CREATE TABLE IF NOT EXISTS inv_stock_ledger (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      material_id BIGINT NOT NULL,
      location_id BIGINT NOT NULL,
      txn_date DATETIME DEFAULT CURRENT_TIMESTAMP,
      txn_type ENUM('GRN','ISSUE','RET','ADJ') NOT NULL,
      qty DECIMAL(14,3) NOT NULL,
      rate DECIMAL(14,3) NOT NULL,
      ref_table VARCHAR(50), ref_id BIGINT,
      FOREIGN KEY (material_id) REFERENCES itm_material(id),
      FOREIGN KEY (location_id) REFERENCES inv_location(id),
      INDEX(material_id, location_id, txn_date))");
  }
  public function down(){
    $this->db->query('DROP TABLE IF EXISTS inv_stock_ledger');
    $this->db->query('DROP TABLE IF EXISTS inv_location');
    $this->db->query('DROP TABLE IF EXISTS itm_material');
    $this->db->query('DROP TABLE IF EXISTS itm_uom');
  }
}
