<?php

namespace App\Services\MachineLearning\Models;

use App\Services\MachineLearning\ImagesDataset\ImageTransformer;
use App\Services\MachineLearning\ImagesDataset\ImageTypes;
use Rubix\ML\Classifiers\ClassificationTree;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

class EstimatorFactory
{
    public static function createClassificationTree(): ClassificationTree
    {
        return new ClassificationTree(25,16,0.001);
    }
    public static function newTrainedClassificationTree(string $pathResources): ClassificationTree
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
    public static function persisteNewTrainedClassificationTree(
        string $pathResources,
        string $pathResults
    ): void
    {
        $estimator = new ClassificationTree(25,16,0.001);
        $persistentEstimator = new PersistentModel(
            $estimator,
            new Filesystem($pathResults . '/classification_tree.rbx')
        );
        $imageTransformer = ( new ImageTransformer($pathResources) )
            ->getDatasetFromImageTypes(
                ImageTypes::TRAINING
            );
        $persistentEstimator->train(
            $imageTransformer['dataset']
        );
        $persistentEstimator->save();
    }
}