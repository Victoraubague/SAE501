<?php

namespace App\Services\MachineLearning\ImagesDataSet;

use Rubix\ML\Datasets\Dataset;

class ImagesDataset
{
    public protected(set) Dataset $dataset;
    /**
     * List of labels for the $dataset
     * @var string[]
     */
    public protected(set) array $labels = [];
    private static ?ImagesDataset $instance = null;
    static public function getInstance(): ImagesDataset
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @throws \Exception
     */
    private function __construct()
    {
        throw new \Exception(
            "Impossible d'instancier la classe ImagesDataset, utilisez plutôt les classes TrainingDataset ou TestingDataset"
        );
    }
}