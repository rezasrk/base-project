<?php

namespace Tests\Feature\Controllers\Profile\V1;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class DeleteSignatureFileTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_delete_own_signature()
    {
        $signPath = 'storage/sign/path/to/sign.png';

        $user = User::factory()->create([
            'signature_path' => $signPath
        ]);

        $response = $this->actingAsUser($user)->deleteJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.delete', ['title' => __('title.sign')])
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'signature_path' => null
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_no_delete_signature()
    {
        $response = $this->deleteJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    private function getRoute()
    {
        return route('delete-signature');
    }
}
