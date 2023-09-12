<?php

namespace Tests\Feature\Controllers\Profile\V1;

use App\Http\Controllers\Profile\V1\UploadSignatureController;
use App\Http\Requests\Profile\V1\UploadSignatureRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class UploadSignatureControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_upload_signature_successfully()
    {
        Storage::fake();
        $signatureFile = 'signature.png';
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->putJson($this->getRoute(), [
            'signature_file' => UploadedFile::fake()->image($signatureFile),
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonPath('status', 'success');
        $response->assertJsonPath('message', __('messages.upload', ['title' => __('title.signature')]));
        $response->assertJson(function (AssertableJson $json) {
            $json->has('data')->etc();
        });
        $this->assertNotEmpty($user->fresh()->signature_path);
    }

    /** @test */
    public function unauthenticated_user_can_not_upload_signature()
    {
        $response = $this->putJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function upload_signature_has_correct_rule_validation()
    {
        $this->assertEquals([
            'signature_file' => ['required'],
        ], (new UploadSignatureRequest())->rules());
    }

    /** @test */
    public function upload_signature_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(UploadSignatureController::class,'__invoke',UploadSignatureRequest::class);
    }

    private function getRoute()
    {
        return route('upload-signature');
    }
}
