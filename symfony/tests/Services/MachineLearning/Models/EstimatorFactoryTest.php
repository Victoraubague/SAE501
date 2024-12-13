<?php

namespace App\Tests\Services\MachineLearning\Models;

use App\Services\MachineLearning\Models\EstimatorFactory;
use PHPUnit\Framework\TestCase;
use Rubix\ML\Classifiers\ClassificationTree;

class EstimatorFactoryTest extends TestCase
{
    public function testCreateClassificationTree(): void
    {
        $estimator = EstimatorFactory::createClassificationTree();
        $this->assertInstanceOf(ClassificationTree::class, $estimator);
    }
    /*public function testTrainNewClassificationTree(): void
    {
        $estimator = EstimatorFactory::TrainNewClassificationTree();
        $this->assertInstanceOf(ClassificationTree::class, $estimator);
    }*/
}