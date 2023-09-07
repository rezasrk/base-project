<?php

namespace App\Http\Controllers\Settings\V1\Projects;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\V1\Projects\ShowProjectService;

class ShowProjectController extends Controller
{
    public function __invoke(int $projectId, ShowProjectService $showProjectService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.project')]),
            $showProjectService->handle($projectId)
        );
    }
}
