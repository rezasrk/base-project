<?php

namespace Tests\Feature\Controllers\Settings\Projects;

use App\Http\Controllers\Settings\Projects\StoreProjectController;
use App\Http\Requests\Settings\Projects\StoreProjectRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class StoreProjectControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_store_project_successfully()
    {
        $title = 'project-title';

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'title' => $title,
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.store', ['title' => __('title.project')]),
        ]);
        $this->assertDatabaseHas('projects', [
            'project_title' => $title,
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_store_project()
    {
        $response = $this->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_store_project_when_the_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    /** @test */
    public function store_projects_has_correct_validation_rules()
    {
        $this->assertEquals([
            'title' => ['required', 'unique:projects,project_title', 'max:190'],
        ], (new StoreProjectRequest())->rules());
    }

    /** @test */
    public function store_projects_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(StoreProjectController::class, '__invoke', StoreProjectRequest::class);
    }

    private function getRoute()
    {
        return route('settings.v1.projects.store');
    }
}
