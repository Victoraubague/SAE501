<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Services\MachineLearning\Models\EstimatorFactory;

ini_set('memory_limit', '3G');

$pathResources = getcwd() . "/resources/images";
$pathResults = getcwd() . "/resources/models";
if (file_exists($pathResults . '/classification_tree.rbx'))
    unlink($pathResults . '/classification_tree.rbx');
EstimatorFactory::persisteNewTrainedClassificationTree($pathResources, $pathResults);

ini_set('memory_limit', '128M');