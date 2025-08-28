<?php
// Minimal front controller to be used within a Composer-based CI4 project.
// If used directly, ensure vendor/autoload.php and system/bootstrap.php exist.
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
$pathsPath = FCPATH . '../app/Config/Paths.php';
if (! is_file($pathsPath)) {
    echo 'Please install CodeIgniter 4 via Composer or copy this bundle into a CI4 appstarter.';
    exit(1);
}
require FCPATH . '../vendor/autoload.php';
require $pathsPath;
$paths = new Config\Paths();
chdir(dirname($paths->systemDirectory));
require rtrim($paths->systemDirectory, '\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app = Config\Services::codeigniter();
$app->run();
