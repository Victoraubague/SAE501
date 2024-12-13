<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadController extends AbstractController
{
    /**
     * Gère l'upload via AJAX et traite l'image ailleurs.
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

        // autoriser seulement PNG et JPEG
        $allowedMimeTypes = $this->getParameter('allowed_mime_types');
        if (!in_array($image->getMimeType(), $allowedMimeTypes, true)) {
            return new JsonResponse(['status' => 'error', 'message' => 'Seuls les fichiers PNG et JPEG sont acceptés.'], 400);
        }

        // Vérif taille du fichier
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($image->getSize() > $maxSize) {
            return new JsonResponse(['status' => 'error', 'message' => 'Le fichier est trop volumineux.'], 400);
        }


        $processedResult = 'Faut link ici la méthode de l/ia';

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Traitement de l\'image réussi.',
            'data' => $processedResult,
        ], 200);
    }
}
