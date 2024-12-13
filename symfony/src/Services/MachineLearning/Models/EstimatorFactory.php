<?php

namespace App\Services\MachineLearning\Models;

use App\Services\MachineLearning\ImagesDataset\ImageTransformer;
use App\Services\MachineLearning\ImagesDataset\ImageTypes;
use Rubix\ML\Classifiers\ClassificationTree;

class EstimatorFactory
{
    public static function createClassificationTree(): ClassificationTree
    {
        return new ClassificationTree(25,16,0.001);
    }
    public static function newTrainedClassificationTree(string $pathResources)//: ClassificationTree
    {
        $estimator = new ClassificationTree(25,16,0.001);
        $imageTransformer = ( new ImageTransformer($pathResources) )
            ->getDatasetFromImageTypes(
                ImageTypes::TRAINING
            );
        $estimator->train(
            $imageTransformer['dataset']
        );
        return $estimator;
    }
}