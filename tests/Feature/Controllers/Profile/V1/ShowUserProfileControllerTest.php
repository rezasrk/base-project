<?php

namespace Tests\Feature\Controllers\Profile\V1;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class ShowUserProfileControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_own_profile_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.user_profile')]),
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'name' => $user->name,
                'family' => $user->family,
                'sign' => $user->signature_path,
            ],
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_own_profile()
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
        return route('show-user-profile');
    }
}
