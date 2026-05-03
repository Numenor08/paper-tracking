<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaperShowController extends Controller
{
    public function show(Request $request, Paper $paper)
    {
        $paper->load(['contributors', 'statusHistories', 'index', 'urlAttachment']);

        $paperArray = $paper->toArray();

        // Normalize attachments and document media for frontend
        $paperArray['url_attachments'] = $paper->urlAttachment->map(function ($u) {
            return [
                'id' => $u->id,
                'title' => $u->title ?? null,
                'url' => $u->url,
            ];
        })->values()->toArray();

        // Get document from Spatie Media Library collection
        $paperArray['document'] = null;
        $media = $paper->getFirstMedia('paper_documents');
        if ($media) {
            $paperArray['document'] = [
                'id' => $media->id,
                'file_name' => $media->file_name ?? null,
                'url' => $media->getFullUrl(),
                'preview_url' => route('papers.documents.preview', $paper),
                'download_url' => route('papers.documents.download', $paper),
                'mime_type' => $media->mime_type ?? null,
                'size' => $media->size ?? null,
            ];
        }

        return Inertia::render('paper-show', [
            'paper' => $paperArray,
        ]);
    }
}
