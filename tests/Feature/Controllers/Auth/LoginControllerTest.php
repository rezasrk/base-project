<?php

namespace Tests\Feature\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class LoginControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function admin_can_login_successfullyy_with_correct_username_and_password()
    {
        $username = 'admin';
        $password = 'RKSHcjk38745';
        User::factory()->create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson($this->getRoute(), [
            'username' => $username,
            'password' => $password,
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data.token')->etc());
    }

    /** @test */
    public function admin_can_login_successfullyy_with_email_and_password()
    {
        $email = 'admin@gmail.com';
        $password = 'RKSHcjk38745';
        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson($this->getRoute(), [
            'username' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data.token')->etc());
    }

    /** @test */
    public function admin_can_not_login_with_incorrect_username()
    {
        $username = 'admin';
        $password = 'RKSHcjk38745';
        User::factory()->create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson($this->getRoute(), [
            'username' => $username.'-extra',
            'password' => $password,
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.authenticate_failed'),
        ]);
    }

    /** @test */
    public function admin_can_not_login_with_incorrect_email()
    {
        $username = 'admin@gmail.com';
        $password = 'RKSHcjk38745';
        User::factory()->create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson($this->getRoute(), [
            'username' => $username.'-extra',
            'password' => $password,
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.authenticate_failed'),
        ]);
    }

    /** @test */
    public function admin_can_not_login_with_username_when_password_is_incorrect()
    {
        $username = 'admin';
        $password = 'RKSHcjk38745';
        User::factory()->create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson($this->getRoute(), [
            'username' => $username,
            'password' => $password.'-extra',
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.authenticate_failed'),
        ]);
    }

    /** @test */
    public function admin_can_not_login_with_email_when_password_is_incorrect()
    {
        $username = 'admin@gmail.com';
        $password = 'RKSHcjk38745';
        User::factory()->create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson($this->getRoute(), [
            'username' => $username,
            'password' => $password.'-extra',
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.authenticate_failed'),
        ]);
    }

    /** @test */
    public function admin_login_has_correct_rules()
    {
        $this->assertEquals([
            'username' => ['required', 'max:190'],
            'password' => ['required', 'max:190'],
        ], (new LoginRequest())->rules());
    }

    /** @test */
    public function admin_login_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(LoginController::class, '__invoke', LoginRequest::class);
    }

    private function getRoute()
    {
        return route('login');
    }
}
