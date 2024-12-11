<?php

namespace App\Tests\Services\MachineLearning\ImagesDataSet;

use App\Services\MachineLearning\ImagesDataSet\ImagesDataset;
use PHPUnit\Framework\TestCase;

class ImagesDatasetTest extends TestCase
{
    public function testGetInstance()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Impossible d'instancier la classe ImagesDataset, utilisez plutôt les classes TrainingDataset ou TestingDataset");
        ImagesDataset::getInstance();
    }
}