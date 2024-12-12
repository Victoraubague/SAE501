<?php

namespace App\Services\MachineLearning\Models;

use Rubix\ML\Classifiers\ClassificationTree;

class EstimatorFactory
{
    public static function createClassificationTree(): ClassificationTree
    {
        return new ClassificationTree(25,16,0.001);
    }
}