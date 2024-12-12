<?php

namespace App\Services\MachineLearning\ImagesDataset;

use Exception;
use GdImage;

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
     * @return array<array<GdImage>|string> ['images' => Transformed images, 'labels' => Labels]
     * @throws Exception If one image is not found
     */
    public function getDatasetAndLabelsFromImagesPathsList(
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
}