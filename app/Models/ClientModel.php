<?php namespace App\Models; use CodeIgniter\Model;
class ClientModel extends Model {
  protected $table = 'org_client';
  protected $allowedFields = ['name','gstin','billing_address','shipping_address','email','phone','pan'];
}