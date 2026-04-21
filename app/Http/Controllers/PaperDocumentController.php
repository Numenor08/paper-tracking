<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaperDocumentController extends Controller
{
    public function preview(Request $request, Paper $paper): StreamedResponse
    {
        $this->authorizePaperAccess($paper, $request->user());

        $media = $paper->getFirstMedia('paper_documents');

        abort_if($media === null, 404);

        return $media->toInlineResponse($request);
    }

    public function download(Request $request, Paper $paper): StreamedResponse
    {
        $this->authorizePaperAccess($paper, $request->user());

        $media = $paper->getFirstMedia('paper_documents');

        abort_if($media === null, 404);

        return $media->toResponse($request);
    }

    protected function authorizePaperAccess(Paper $paper, mixed $user): void
    {
        abort_unless($user instanceof User, 403);

        abort_unless($user->isAdmin() || $paper->created_by === $user->id, 403);
    }
}
