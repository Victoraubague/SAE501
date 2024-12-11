<?php

namespace App\Services\MachineLearning\ImagesDataSet;

use Rubix\ML\Datasets\Dataset;

class TrainingDataset extends ImagesDataset
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
}