<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Rubix\ML\PersistentModel;
use App\Services\MachineLearning\ImagesDataset\ImageTransformer;

class UploadController extends AbstractController
{
    /**
     * Gère l'upload via AJAX et traite l'image avec l'IA.
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/ajax/upload', name: 'ajax_upload', methods: ['POST'])]
    public function ajaxUpload(Request $request): JsonResponse
    {
        /** @var UploadedFile|null $image */
        $image = $request->files->get('image');

        if (!$image) {
            return new JsonResponse(['status' => 'error', 'message' => 'Aucune image sélectionnée.'], 400);
        }

        $allowedMimeTypes = $this->getParameter('allowed_mime_types');
        if (!in_array($image->getMimeType(), $allowedMimeTypes, true)) {
            return new JsonResponse(['status' => 'error', 'message' => 'Seuls les fichiers PNG et JPEG sont acceptés.'], 400);
        }
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($image->getSize() > $maxSize) {
            return new JsonResponse(['status' => 'error', 'message' => 'Le fichier est trop volumineux.'], 400);
        }

        $uploadsDir = $this->getParameter('kernel.project_dir') . '/uploads';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }
        $filePath = $uploadsDir . '/' . uniqid() . '.' . $image->guessExtension();
        $image->move($uploadsDir, basename($filePath));

        try {
            $modelPath = $this->getParameter('kernel.project_dir') . '/resources/models/classification_tree.rbx';
            $model = PersistentModel::load(new \Rubix\ML\Persisters\Filesystem($modelPath));

            $imageTransformer = new ImageTransformer($uploadsDir);
            $transformedImage = $imageTransformer->transformImage($filePath);
            $dataset = $imageTransformer->getDatasetFromTransformedImages([$transformedImage]);

            $predictions = $model->predict($dataset);

            unlink($filePath);

            error_log('Résultats de la prédiction : ' . implode(', ', $predictions));

            $html = '<div id="prediction-result">';
            $html .= '<p>Résultat de la prédiction : Image = ' . $predictions[0] . '</p>';
            $html .= '</div>';

            return new JsonResponse([
                'status' => 'success',
                'message' => 'Traitement de l\'image réussi.',
                'data' => $html,
            ], 200);
        } catch (\Exception $e) {

            return new JsonResponse([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors du traitement : ' . $e->getMessage(),
            ], 500);
        }
    }
}