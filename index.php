<?php
session_start();
require_once __DIR__ . '/controllers/FrontController.php';

$frontController = new FrontController();
$frontController->handleRequest();
?>