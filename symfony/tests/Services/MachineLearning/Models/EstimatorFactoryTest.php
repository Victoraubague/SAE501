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
    public function testNewTrainedClassificationTree(): void
    {
        $estimator = EstimatorFactory::newTrainedClassificationTree(__DIR__ . '/../ImagesDataSet/Resources/images');
        $this->assertInstanceOf(ClassificationTree::class, $estimator);
        $this->assertTrue($estimator->trained());
    }
}