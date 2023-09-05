<?php

namespace Tests\Feature\Controllers\Settings\Roles;

use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class IndexPermissionControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_permissions_successfully()
    {
        $response = $this->actingAsSuperUser()->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonPath('status', 'success');
        $response->assertJsonPath('message', __('messages.fetch', ['title' => __('title.permission')]));
    }

    /** @test */
    public function unauthenticated_user_can_not_see_permissions()
    {
        $response = $this->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    private function getRoute()
    {
        return route('settings.v1.permission.index');
    }
}
