<?php

namespace Tests\Feature\Controllers\Profile;

use App\Http\Controllers\Profile\ChangeUserPasswordController;
use App\Http\Requests\Profile\ChangeUserPasswordRequest;
use App\Models\User;
use App\Rules\StrongPasswordRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class ChangeUserPasswordControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_change_own_password_successfully()
    {
        $oldPassword = 'password';
        $oldPasswordHash = '$2y$10$TP4OETFuOgh52nM9Wq69AeOR.Xqsg.FrHKocAVb.GP2eDoRT3T6uK';
        $newPassword = 'AJdkca574532sk';
        $user = User::factory()->create([
            'password' => $oldPasswordHash
        ]);

        $response = $this->actingAsUser($user)->putJson($this->getRoute(), [
            'old_password' => $oldPassword,
            'new_password' => $newPassword
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.user_password')])
        ]);
        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }

    /** @test */
    public function authenticated_user_can_not_change_own_password_when_old_password_is_incorrect()
    {
        $oldPassword = 'password';
        $oldPasswordHash = '$2y$10$TP4OETFuOgh52nM9Wq69AeOR.Xqsg.FrHKocAVb.GP2eDoRT3T6uK';
        $newPassword = 'AJdkca574532sk';
        $user = User::factory()->create([
            'password' => $oldPasswordHash . '-extra'
        ]);

        $response = $this->actingAsUser($user)->putJson($this->getRoute(), [
            'old_password' => $oldPassword,
            'new_password' => $newPassword
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'old_password' => [
                    __('messages.old_password_wrong')
                ]
            ],
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_change_own_password()
    {
        $response = $this->putJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function change_user_password_has_correct_validation_rules()
    {
        $this->assertEquals([
            'old_password' => ['required', 'min:8', 'max:190'],
            'new_password' => ['required', 'min:8', 'max:190', new StrongPasswordRule]
        ], (new ChangeUserPasswordRequest())->rules());
    }

    /** @test */
    public function change_user_password_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(ChangeUserPasswordController::class, '__invoke', ChangeUserPasswordRequest::class);
    }

    private function getRoute(): string
    {
        return route('change-user-password');
    }
}
