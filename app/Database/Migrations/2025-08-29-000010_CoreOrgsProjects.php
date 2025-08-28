<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CoreOrgsProjects extends Migration {
  public function up(){
    $this->db->query("CREATE TABLE IF NOT EXISTS org_client (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      name VARCHAR(190) NOT NULL,
      gstin VARCHAR(20), billing_address TEXT, shipping_address TEXT,
      email VARCHAR(190), phone VARCHAR(30), pan VARCHAR(20),
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");

    $this->db->query("CREATE TABLE IF NOT EXISTS prj_project (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      client_id BIGINT NOT NULL,
      code VARCHAR(50) UNIQUE,
      name VARCHAR(190) NOT NULL,
      start_date DATE, end_date DATE,
      status ENUM('planning','in_progress','on_hold','completed','closed') DEFAULT 'planning',
      budget DECIMAL(14,2) DEFAULT 0,
      retention_pct DECIMAL(5,2) DEFAULT 5.00,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (client_id) REFERENCES org_client(id))");

    $this->db->query("CREATE TABLE IF NOT EXISTS prj_milestone (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      project_id BIGINT NOT NULL,
      name VARCHAR(190) NOT NULL,
      due_date DATE,
      amount DECIMAL(14,2) NOT NULL,
      status ENUM('planned','invoiced','paid','overdue') DEFAULT 'planned',
      sort_order INT DEFAULT 0,
      FOREIGN KEY (project_id) REFERENCES prj_project(id))");
  }
  public function down(){
    $this->db->query('DROP TABLE IF EXISTS prj_milestone');
    $this->db->query('DROP TABLE IF EXISTS prj_project');
    $this->db->query('DROP TABLE IF EXISTS org_client');
  }
}
