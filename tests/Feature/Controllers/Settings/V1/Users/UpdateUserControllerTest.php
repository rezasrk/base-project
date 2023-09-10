<?php

namespace Tests\Feature\Controllers\Settings\V1\Users;

use App\Enum\BaseinfoTypesEnum;
use App\Enum\RequestStatusEnum;
use App\Enum\RequestTypesEnum;
use App\Http\Controllers\Settings\V1\Users\UpdateUserController;
use App\Http\Requests\Settings\V1\Users\UpdateUserRequest;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Rules\StrongPasswordRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class UpdateUserControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_update_a_user_successfully_without_change_password()
    {
        $hashPassword = '$2y$10$LsTORwvEDkyrNP/eNbI6UuL8RKpx3KfOx5YC9dLrqmfbI9LreHUOO';
        $user = User::factory()->create([
            'username' => 'admin',
            'name' => 'name',
            'family' => 'family',
            'access_request' => [
                'statuses' => [RequestStatusEnum::ASSIGN_TO_BUYER->value],
                'types' => [RequestTypesEnum::SUPPLY->value],
            ],
            'password' => $hashPassword,
        ]);
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        $project = Project::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($user->id), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'projects' => [$project->id],
            'request_statuses' => [RequestStatusEnum::ACCEPT->value],
            'request_types' => [RequestTypesEnum::SUPPLIED_BEFORE],
            'roles' => [$role->id]
        ]);

        $user = User::query()->where('username', $username)->first();
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.user')])
        ]);
        $this->assertDatabaseHas('users', [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'password' => $hashPassword
        ]);
        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $role->id,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);
        $this->assertEquals([
            RequestStatusEnum::ACCEPT->value
        ], $user->access_request['statuses']);
        $this->assertEquals([
            RequestTypesEnum::SUPPLIED_BEFORE->value,
        ], $user->access_request['types']);
    }

    /** @test */
    public function authenticated_user_can_update_a_user_successfully_with_same_username_without_change_password()
    {
        $hashPassword = '$2y$10$LsTORwvEDkyrNP/eNbI6UuL8RKpx3KfOx5YC9dLrqmfbI9LreHUOO';
        $user = User::factory()->create([
            'username' => 'username',
            'name' => 'name',
            'family' => 'family',
            'access_request' => [
                'statuses' => [RequestStatusEnum::ASSIGN_TO_BUYER->value],
                'types' => [RequestTypesEnum::SUPPLY->value],
            ],
            'password' => $hashPassword,
        ]);
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        $project = Project::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($user->id), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'projects' => [$project->id],
            'request_statuses' => [RequestStatusEnum::ACCEPT->value],
            'request_types' => [RequestTypesEnum::SUPPLIED_BEFORE],
            'roles' => [$role->id]
        ]);

        $user = User::query()->where('username', $username)->first();
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.user')])
        ]);
        $this->assertDatabaseHas('users', [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'password' => $hashPassword
        ]);
        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $role->id,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);
        $this->assertEquals([
            RequestStatusEnum::ACCEPT->value
        ], $user->access_request['statuses']);
        $this->assertEquals([
            RequestTypesEnum::SUPPLIED_BEFORE->value,
        ], $user->access_request['types']);
    }

    /** @test */
    public function authenticated_user_can_update_a_user_successfully_with_change_password()
    {
        $hashPassword = '$2y$10$LsTORwvEDkyrNP/eNbI6UuL8RKpx3KfOx5YC9dLrqmfbI9LreHUOO';
        $user = User::factory()->create([
            'username' => 'admin',
            'name' => 'name',
            'family' => 'family',
            'access_request' => [
                'statuses' => [RequestStatusEnum::ASSIGN_TO_BUYER->value],
                'types' => [RequestTypesEnum::SUPPLY->value],
            ],
            'password' => $hashPassword,
        ]);
        $newPassword = 'Password123';
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        $project = Project::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($user->id), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'projects' => [$project->id],
            'request_statuses' => [RequestStatusEnum::ACCEPT->value],
            'request_types' => [RequestTypesEnum::SUPPLIED_BEFORE],
            'roles' => [$role->id],
            'password' => $newPassword,
        ]);

        $user = User::query()->where('username', $username)->first();
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.user')])
        ]);
        $this->assertDatabaseHas('users', [
            'username' => $username,
            'name' => $name,
            'family' => $family,
        ]);
        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $role->id,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);
        $this->assertEquals([
            RequestStatusEnum::ACCEPT->value
        ], $user->access_request['statuses']);
        $this->assertEquals([
            RequestTypesEnum::SUPPLIED_BEFORE->value,
        ], $user->access_request['types']);
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function unauthenticated_user_can_not_update_a_user()
    {
        $response = $this->putJson($this->getRoute(123));

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_a_user_when_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->putJson($this->getRoute($user->id));

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_a_user_when_username_already_exists()
    {
        $hashPassword = '$2y$10$LsTORwvEDkyrNP/eNbI6UuL8RKpx3KfOx5YC9dLrqmfbI9LreHUOO';
        $user = User::factory()->create([
            'username' => 'admin',
            'name' => 'name',
            'family' => 'family',
            'access_request' => [
                'statuses' => [RequestStatusEnum::ASSIGN_TO_BUYER->value],
                'types' => [RequestTypesEnum::SUPPLY->value],
            ],
            'password' => $hashPassword,
        ]);
        $newPassword = 'Password123';
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        User::factory()->create(['username' => $username]);
        $project = Project::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($user->id), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'projects' => [$project->id],
            'request_statuses' => [RequestStatusEnum::ACCEPT->value],
            'request_types' => [RequestTypesEnum::SUPPLIED_BEFORE],
            'roles' => [$role->id],
            'password' => $newPassword,
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'username' => [
                    __('validation.unique', ['attribute' => 'username'])
                ]
            ]
        ]);
    }

    /** @test */
    public function update_user_has_correct_validation_rules()
    {
        $userId = 54;
        $updateUserRequest = new UpdateUserRequest();
        $updateUserRequest->setRouteResolver(function () use ($userId) {
            $route = new Route('put', $this->getRoute($userId), [UpdateUserController::class]);
            $route->parameters['id'] =  $userId;

            return $route;
        });

        $this->assertEquals([
            'username' => ['required', 'unique:users,username,' . $userId . ',id'],
            'name' => ['required', 'string', 'max:160'],
            'family' => ['required', 'string', 'max:160'],
            'password' => ['nullable', new StrongPasswordRule],
            'projects' => ['present', 'array', 'min:1'],
            'request_statuses' => ['present', 'array', 'min:1'],
            'request_types' => ['present', 'array', 'min:1'],
            'roles' => ['present', 'array', 'min:1'],
            'projects.*' => ['required', 'int', 'exists:projects,id'],
            'request_statuses.*' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_STATUS->value],
            'request_types.*' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_TYPE->value],
            'roles.*' => ['required', 'exists:roles,id'],
        ], $updateUserRequest->rules());
    }

    /** @test */
    public function update_user_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(UpdateUserController::class, '__invoke', UpdateUserRequest::class);
    }

    private function getRoute(int $userId)
    {
        return route('settings.v1.users.update', $userId);
    }
}
