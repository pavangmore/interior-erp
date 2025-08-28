<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Design extends ResourceController {
  protected $format = 'json';
  public function presign(){
    // Placeholder for S3/GCS presign logic
    // Return a dummy URL for now
    return $this->respond(['uploadUrl' => '/uploads/mock','key'=>'designs/example.glb']);
  }
}
