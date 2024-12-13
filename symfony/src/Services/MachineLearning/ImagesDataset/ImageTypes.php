<?php

namespace App\Services\MachineLearning\ImagesDataset;

enum ImageTypes: string {
    case TRAINING = "training";
    case TESTING = "testing";
}