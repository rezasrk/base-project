<?php

namespace Tests\Feature\Controllers\Profile\V1;

use App\Http\Controllers\Profile\V1\UpdateUserProfileController;
use App\Http\Requests\Profile\V1\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class UpdateUserProfileControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;
    use WithFaker;

    /** @test */
    public function authenticated_user_can_update_profile_information_successfully_with_required_data()
    {
        $newUsername = $this->faker->userName();
        $newEmail = $this->faker->email();
        $newName = $this->faker->name();
        $newFamily = $this->faker->name();
        $user = User::factory()->create([
            'username' => $this->faker->userName(),
            'email' => $this->faker->email(),
            'name' => $this->faker->name(),
            'family' => $this->faker->name(),
        ]);

        $response = $this->actingAsUser($user)->putJson($this->getRoute(), [
            'username' => $newUsername,
            'email' => $newEmail,
            'name' => $newName,
            'family' => $newFamily,
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.user_profile')]),
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => $newUsername,
            'email' => $newEmail,
            'name' => $newName,
            'family' => $newFamily,
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_profile_information_when_user_use_a_username_that_already_exists()
    {
        $newUsername = $this->faker->userName();
        $newEmail = $this->faker->email();
        $newName = $this->faker->name();
        $newFamily = $this->faker->name();
        $user = User::factory()->create();
        /** Other user that has username equal $newUsername */
        User::factory()->create([
            'username' => $newUsername,
        ]);

        $response = $this->actingAsUser($user)->putJson($this->getRoute(), [
            'username' => $newUsername,
            'email' => $newEmail,
            'name' => $newName,
            'family' => $newFamily,
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'username' => [
                    __('validation.unique', ['attribute' => 'username']),
                ],
            ],
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_profile_information_when_user_use_a_email_that_already_exists()
    {
        $newUsername = $this->faker->userName();
        $newEmail = $this->faker->email();
        $newName = $this->faker->name();
        $newFamily = $this->faker->name();
        $user = User::factory()->create();
        /** Other user that has email equal $newEmail */
        User::factory()->create([
            'email' => $newEmail,
        ]);

        $response = $this->actingAsUser($user)->putJson($this->getRoute(), [
            'username' => $newUsername,
            'email' => $newEmail,
            'name' => $newName,
            'family' => $newFamily,
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'email' => [
                    __('validation.unique', ['attribute' => 'email']),
                ],
            ],
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_update_profile_information()
    {
        $response = $this->putJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function update_user_profile_has_correct_validation_rules()
    {
        $user = User::factory()->create();
        $updateUserProfileRequest = new UpdateUserProfileRequest();
        $updateUserProfileRequest->setUserResolver(function () use ($user) {
            return $user;
        });

        $this->assertEquals([
            'username' => ['required', 'max:100', 'unique:users,username,'.$user->id.',id'],
            'email' => ['required', 'max:190', 'unique:users,email,'.$user->id.',id'],
            'name' => ['required', 'max:100'],
            'family' => ['required', 'max:100'],
        ], $updateUserProfileRequest->rules());
    }

    public function update_user_profile_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(UpdateUserProfileController::class, '__invoke', UpdateUserProfileRequest::class);
    }

    private function getRoute()
    {
        return route('update-user-profile');
    }
}
