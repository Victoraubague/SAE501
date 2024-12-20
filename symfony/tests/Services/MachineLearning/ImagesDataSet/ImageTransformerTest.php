<?php

namespace App\Tests\Services\MachineLearning\ImagesDataSet;

use App\Services\MachineLearning\ImagesDataset\ImageTransformer;
use App\Services\MachineLearning\ImagesDataset\ImageTypes;
use App\Services\MachineLearning\ImagesDataset\ImageValues;
use GdImage;
use PHPUnit\Framework\TestCase;
use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;

class ImageTransformerTest extends TestCase
{
    public ImageTransformer $transformer;
    public function setUp(): void
    {
        $this->transformer = new ImageTransformer(__DIR__ . "/resources/images");
    }
    public function testTransformImage(): void
    {
        $result = $this->transformer->transformImage(
            __DIR__ . "/resources/images/training/3/good_image_1.png"
        );
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(GdImage::class, $result[0]);
    }
    public function testTransformImageWithInvalidPath(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Image non trouvé au filepath : ''.");
        $this->transformer->transformImage("");
    }
    public function testTransformImageWithInvalidFile(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Le fichier '" . __DIR__ . "/resources/bad_image.png' semble ne pas être une image png valide.");
        $this->transformer->transformImage(
            __DIR__ . "/resources/bad_image.png"
        );
    }
    public function testGetFolderImagesPathFromTypeAndValueForTraining(): void
    {
        $this->assertEquals(
            "/var/www/tests/Services/MachineLearning/ImagesDataSet/resources/images/training/2",
            $this->transformer->getFolderImagesPathFromTypeAndValue(ImageValues::TWO, ImageTypes::TRAINING)
        );
        $this->assertEquals(
            "/var/www/tests/Services/MachineLearning/ImagesDataSet/resources/images/training/4",
            $this->transformer->getFolderImagesPathFromTypeAndValue(ImageValues::FOUR, ImageTypes::TRAINING)
        );
    }
    public function testGetFolderImagesPathFromTypeAndValueForTesting(): void
    {
        $this->assertEquals(
            "/var/www/tests/Services/MachineLearning/ImagesDataSet/resources/images/testing/7",
            $this->transformer->getFolderImagesPathFromTypeAndValue(ImageValues::SEVEN, ImageTypes::TESTING)
        );
        $this->assertEquals(
            "/var/www/tests/Services/MachineLearning/ImagesDataSet/resources/images/testing/3",
            $this->transformer->getFolderImagesPathFromTypeAndValue(ImageValues::THREE, ImageTypes::TESTING)
        );
    }
    public function testGetImagesPathsListFromFolderImagesPath()
    {
        $imagesPaths = $this->transformer->getImagesPathsListFromFolderImagesPath(
            __DIR__ . "/resources"
        );
        $this->assertIsArray($imagesPaths);
        $this->assertNotEmpty($imagesPaths);
    }
    public function testTransformedImagesAndLabelsFromImagesPathsList(): void
    {
        [
            'images' => $images,
            'labels' => $labels
        ] = $this->transformer->getTransformedImagesAndLabelsFromImagesPathsList(
            [
                __DIR__ . "/resources/good_image_1.png",
                __DIR__ . "/resources/good_image_2.png",
                __DIR__ . "/resources/good_image_3.png"
            ],
            "7"
        );
        $this->assertIsArray($images);
        $this->assertIsArray($labels);
        $this->assertSameSize($images, $labels);
        $this->assertContainsOnlyArray($images);
        $this->assertContainsOnlyString($labels);
    }
    public function testGetTransformedImagesAndLabelsFromBadImagesPathsList(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Le fichier '" . __DIR__ . "/resources/bad_image.png' semble ne pas être une image png valide.");
        [
            'images' => $images,
            'labels' => $labels
        ] = $this->transformer->getTransformedImagesAndLabelsFromImagesPathsList(
            [
                __DIR__ . "/resources/good_image_1.png",
                __DIR__ . "/resources/good_image_2.png",
                __DIR__ . "/resources/bad_image.png",
                __DIR__ . "/resources/good_image_3.png"
            ],
            "7"
        );
    }
    public function testGetLabeledDatasetFromTransformedImages(): void
    {
        $dataset = $this->transformer->getDatasetFromTransformedImages(
            [
                [imagecreatefrompng(__DIR__ . "/resources/good_image_1.png")],
                [imagecreatefrompng(__DIR__ . "/resources/good_image_2.png")],
                [imagecreatefrompng(__DIR__ . "/resources/good_image_3.png")]
            ],
            [
                "7",
                "7",
                "3"
            ]
        );
        $this->assertInstanceOf(Labeled::class, $dataset);
    }
    public function testGetUnlabeledDatasetFromTransformedImages(): void
    {
        $dataset = $this->transformer->getDatasetFromTransformedImages(
            [
                [imagecreatefrompng(__DIR__ . "/resources/good_image_1.png")],
                [imagecreatefrompng(__DIR__ . "/resources/good_image_2.png")],
                [imagecreatefrompng(__DIR__ . "/resources/good_image_3.png")]
            ]
        );
        $this->assertInstanceOf(Unlabeled::class, $dataset);
    }
    public function testGetDatasetFromTraining(): void
    {
        $result = $this->transformer->getDatasetFromImageTypes(
            ImageTypes::TRAINING
        );
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Dataset::class, $result["dataset"]);
        $this->assertIsArray($result["labels"]);
        $this->assertContainsOnlyString($result["labels"]);
    }
}