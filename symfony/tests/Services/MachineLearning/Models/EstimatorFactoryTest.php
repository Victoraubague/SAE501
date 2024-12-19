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
        $pathResources = __DIR__ . '/../ImagesDataSet/Resources/images';
        $estimator = EstimatorFactory::newTrainedClassificationTree($pathResources);
        $this->assertInstanceOf(ClassificationTree::class, $estimator);
        $this->assertTrue($estimator->trained());
    }
    public function testPersisteNewTrainedClassificationTree(): void
    {
        $pathResources = __DIR__ . '/../ImagesDataSet/resources/images';
        $pathResults = __DIR__ . '/../ImagesDataSet/resources/models';
        if (file_exists($pathResults . '/classification_tree.rbx'))
            unlink($pathResults . '/classification_tree.rbx');
        EstimatorFactory::persisteNewTrainedClassificationTree($pathResources, $pathResults);
        $this->assertFileExists($pathResults . '/classification_tree.rbx');
    }
}