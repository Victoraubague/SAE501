<?php

namespace App\Services\MachineLearning\Models;

use App\Services\MachineLearning\ImagesDataset\ImageTransformer;
use Rubix\ML\Classifiers\ClassificationTree;

class EstimatorFactory
{
    public static function createClassificationTree(): ClassificationTree
    {
        return new ClassificationTree(25,16,0.001);
    }
    /*public static function newTrainedClassificationTree(string $pathResources): ClassificationTree
    {
        $estimator = new ClassificationTree(25,16,0.001);
        $estimator->train(
            (new ImageTransformer($pathResources))->getDataSet(DatasetType::TRAINING)
        );
        return $estimator;
    }*/
}