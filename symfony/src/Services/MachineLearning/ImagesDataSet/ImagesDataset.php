<?php

namespace App\Services\MachineLearning\ImagesDataSet;

use Rubix\ML\Datasets\Dataset;

class ImagesDataset
{
    private Dataset $dataset;
    public function getDataset(): Dataset
    {
        return $this->dataset;
    }
    public function setDataset(Dataset $dataset): void
    {
        $this->dataset = $dataset;
    }
    /**
     * List of labels for the $dataset
     * @var string[]
     */
    private array $labels = [];
    public function getLabels(): array
    {
        return $this->labels;
    }
    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
    }
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