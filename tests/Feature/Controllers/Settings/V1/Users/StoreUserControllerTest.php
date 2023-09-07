<?php

namespace Tests\Feature\Controllers\Settings\V1\Users;

use App\Enum\BaseinfoTypesEnum;
use App\Enum\RequestStatusEnum;
use App\Enum\RequestTypesEnum;
use App\Http\Controllers\Settings\V1\Users\StoreUserController;
use App\Http\Requests\Settings\V1\Users\StoreUserRequest;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Rules\StrongPasswordRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class StoreUserControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_add_other_users_successfully()
    {
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        $password = 'Ae43kdhchakdf';
        $project = Project::factory()->create();
        $role = Role::factory()->create();
        $hashPassword = '$2y$10$b3kyR8bEbZLNs4uuYL1JP.yqyYSMmS7oco8a5dvYlguUPea0JFEta';
        Hash::shouldReceive('make')->once()->with($password)->andReturn($hashPassword);

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'password' => $password,
            'projects' => [$project->id],
            'request_statuses' => [RequestStatusEnum::ACCEPT->value],
            'request_types' => [RequestTypesEnum::SUPPLIED_BEFORE],
            'roles' => [$role->id]
        ]);

        $user = User::query()->where('username', $username)->first();
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.store', ['title' => __('title.user')])
        ]);
        $this->assertDatabaseHas('users', [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'password' => $hashPassword,
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
    public function unauthenticated_user_can_not_store_user()
    {
        $response = $this->postJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_store_user_when_user_has_not_permission()
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
    public function authenticated_user_can_not_store_user_when_any_projects_does_not_select()
    {
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        $password = 'Ae43kdhchakdf';
        $role = Role::factory()->create();

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'password' => $password,
            'projects' => [],
            'request_statuses' => [RequestStatusEnum::ACCEPT->value],
            'request_types' => [RequestTypesEnum::SUPPLIED_BEFORE],
            'roles' => [$role->id]
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'projects' => [
                    __('validation.min.array', ['attribute' => 'projects', 'min' => 1])
                ]
            ]
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_store_user_when_any_roles_does_not_select()
    {
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        $password = 'Ae43kdhchakdf';
        $project = Project::factory()->create();

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'password' => $password,
            'projects' => [$project->id],
            'request_statuses' => [RequestStatusEnum::ACCEPT->value],
            'request_types' => [RequestTypesEnum::SUPPLIED_BEFORE],
            'roles' => []
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'roles' => [
                    __('validation.min.array', ['attribute' => 'roles', 'min' => 1])
                ]
            ]
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_store_user_when_any_request_statues_does_not_select()
    {
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        $password = 'Ae43kdhchakdf';
        $project = Project::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'password' => $password,
            'projects' => [$project->id],
            'request_statuses' => [],
            'request_types' => [RequestTypesEnum::SUPPLIED_BEFORE],
            'roles' => [$role->id]
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'request_statuses' => [
                    __('validation.min.array', ['attribute' => 'request statuses', 'min' => 1])
                ]
            ]
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_store_user_when_any_request_types_does_not_select()
    {
        $username = 'username';
        $name = 'Ali';
        $family = 'Mohammad';
        $password = 'Ae43kdhchakdf';
        $project = Project::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAsSuperUser()->postJson($this->getRoute(), [
            'username' => $username,
            'name' => $name,
            'family' => $family,
            'password' => $password,
            'projects' => [$project->id],
            'request_statuses' => [RequestStatusEnum::ACCEPT->value],
            'request_types' => [],
            'roles' => [$role->id]
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'request_types' => [
                    __('validation.min.array', ['attribute' => 'request types', 'min' => 1])
                ]
            ]
        ]);
    }

    /** @test */
    public function store_user_has_correct_validation_rules()
    {
        $this->assertEquals([
            'username' => ['required', 'unique:users,username'],
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
        ], (new StoreUserRequest())->rules());
    }

    /** @test */
    public function store_user_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(StoreUserController::class, '__invoke', StoreUserRequest::class);
    }

    private function getRoute()
    {
        return route('settings.v1.users.store');
    }
}
