<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class BaseAccounts extends Migration {
  public function up(){
    $this->db->query("CREATE TABLE IF NOT EXISTS accounts_user (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      email VARCHAR(190) UNIQUE NOT NULL,
      password_hash VARCHAR(255) NOT NULL,
      full_name VARCHAR(190) NOT NULL,
      phone VARCHAR(30), is_active TINYINT(1) DEFAULT 1,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
    $this->db->query("CREATE TABLE IF NOT EXISTS accounts_role (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      name VARCHAR(100) UNIQUE NOT NULL,
      description VARCHAR(255))");
    $this->db->query("CREATE TABLE IF NOT EXISTS accounts_user_role (
      user_id BIGINT NOT NULL, role_id BIGINT NOT NULL,
      PRIMARY KEY (user_id,role_id),
      FOREIGN KEY (user_id) REFERENCES accounts_user(id),
      FOREIGN KEY (role_id) REFERENCES accounts_role(id))");
  }
  public function down(){
    $this->db->query('DROP TABLE IF EXISTS accounts_user_role');
    $this->db->query('DROP TABLE IF EXISTS accounts_role');
    $this->db->query('DROP TABLE IF EXISTS accounts_user');
  }
}
