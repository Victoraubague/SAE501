<?php

namespace App\Services\MachineLearning\ImagesDataset;

use Exception;
use GdImage;
use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Transformers\ImageVectorizer;

class ImageTransformer
{
    /**
     * Transform an image into an array of images
     * @return GdImage[]
     * @throws Exception
     */
    public function transformImage(string $imagePath): array
    {
        if (!file_exists($imagePath)) {
            throw new Exception("Image non trouvé au filepath : '" . $imagePath . "'.");
        }
        $image = @imagecreatefrompng($imagePath);
        if(!$image) {
            throw new Exception("Le fichier '" . $imagePath . "' semble ne pas être une image png valide.");
        }
        return [
            $image
        ];
    }
    public function getFolderImagesPathFromTypeAndValue(ImageValues $value, ImageTypes $type): string
    {
        return getcwd() . "/resources/images/" . $type->value . "/" . $value->value;
    }
    /**
     * Get the list of png images paths from a folder path
     * @return string[]
     */
    public function getImagesPathsListFromFolderImagesPath(string $folderPath): array
    {
        return glob($folderPath . '/*.png');
    }
    /**
     * Get the list of gd images and labels from a list of images paths
     * @param string[] $imagesPathsList
     * @param string $label The common label associated with the images
     * @return array<array<array<GdImage>>|array<string>> ['images' => Transformed images, 'labels' => Labels]
     * @throws Exception If one image is not found
     */
    public function getTransformedImagesAndLabelsFromImagesPathsList(
        array $imagesPathsList,
        string $label,
    ): array
    {
        $TransformedImages = [];
        $labels = [];
        foreach ($imagesPathsList as $imagePath) {
            $TransformedImages[] = $this->transformImage($imagePath);
            $labels[] = $label;
        }
        return [
            'images' => $TransformedImages,
            'labels' => $labels
        ];
    }
    /**
     * Get the list of gd images and labels from a list of images paths
     * @param array<array<GdImage> $images
     * @throws Exception If one image is not found
     */
    public function getDatasetFromTransformedImages(
        array $images,
        ?array $labels = null
    ): Dataset
    {
        if($labels) {
            return Labeled::build($images, $labels)->apply(new ImageVectorizer(true));
        }
        return Unlabeled::build($images)->apply(new ImageVectorizer(true));
    }

    /**
     * @return array<Dataset|array<string>> ['dataset' => Dataset, 'labels' => Labels]
     */
    public function getDatasetFromImageTypes(
        ImageTypes $type
    ): array
    {
        $images = [];
        $labels = [];
        foreach (ImageValues::cases() as $values) {
            //get directory path
            $folderPath = $this->getFolderImagesPathFromTypeAndValue($values, $type);
            //get images paths
            $imagesPaths = $this->getImagesPathsListFromFolderImagesPath($folderPath);
            //get transformed images and labels
            [
                'images' => $images,
                'labels' => $labels
            ] = $this->getTransformedImagesAndLabelsFromImagesPathsList(
                $imagesPaths,
                $values->value
            );
            array_push($images, ...$images);
            array_push($labels, ...$labels);
        }
        return [
            'dataset' => $this->getDatasetFromTransformedImages(
                $images,
                $type === ImageTypes::TRAINING ? $labels : null
            ),
            'labels' => $labels
        ];
    }
}