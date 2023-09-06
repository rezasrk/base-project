<?php

namespace Tests\Feature\Controllers\Settings\Projects;

use App\Enum\BaseinfoTypesEnum;
use App\Enum\RequestStatusEnum;
use App\Http\Controllers\Settings\Projects\ProjectSettingsController;
use App\Http\Requests\Settings\Projects\ProjectSettingsRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\AdditionalAssertion;
use Tests\Feature\BaseFeatureTestCase;

final class ProjectSettingsControllerTest extends BaseFeatureTestCase
{
    use AdditionalAssertion;

    /** @test */
    public function authenticated_user_can_update_settings_projects_successfully()
    {
        $preRequestCode = '543';
        $firstStatus = RequestStatusEnum::SENT->value;
        $lastStatus = RequestStatusEnum::SUPPLY->value;
        $betweenStatuses = [
            RequestStatusEnum::ACCEPT_FINANCIAL->value,
            RequestStatusEnum::ASSIGN_TO_BUYER->value,
        ];
        $project = Project::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($project->id), [
            'settings' => [
                'supply' => [
                    'pre_request_code' => $preRequestCode,
                    'status' => [
                        'first_status' => $firstStatus,
                        'last_status' => $lastStatus,
                        'between_statuses' => $betweenStatuses
                    ],
                ],
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.update', ['title' => __('title.project_settings')])
        ]);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'settings->supply->pre_request_code' => $preRequestCode,
            'settings->supply->status->first_status' => $firstStatus,
            'settings->supply->status->last_status' => $lastStatus,
        ]);
        $this->assertEquals($betweenStatuses, $project->fresh()->first()->settings['supply']['status']['between_statuses']);
    }

    /** @test */
    public function unauthenticated_user_can_not_update_project_settings()
    {
        $response = $this->putJson($this->getRoute(12344444));

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_project_settings_when_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->putJson($this->getRoute(345322));

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    /** @test */
    public function update_setting_has_correct_validation_rules()
    {
        $this->assertEquals([
            'settings' => ['present', 'array'],
            'settings.supply' => ['present', 'array'],
            'settings.supply.pre_request_code' => ['required', 'string', 'min:3', 'max:3'],
            'settings.supply.status' => ['present', 'array'],
            'settings.supply.status.first_status' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_STATUS->value],
            'settings.supply.status.between_statuses' => ['present', 'array', 'min:2'],
            'settings.supply.status.between_statuses.*' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_STATUS->value],
            'settings.supply.status.last_status' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_STATUS->value],
        ], (new ProjectSettingsRequest())->rules());
    }

    /** @test */
    public function update_setting_has_correct_form_request()
    {
        $this->assertActionUsesFormRequest(ProjectSettingsController::class, '__invoke', ProjectSettingsRequest::class);
    }

    /** @test */
    public function authenticated_user_can_not_update_project_settings_when_project_is_not_exists()
    {
        $preRequestCode = '543';
        $firstStatus = RequestStatusEnum::SENT->value;
        $lastStatus = RequestStatusEnum::SUPPLY->value;
        $betweenStatuses = [
            RequestStatusEnum::ACCEPT_FINANCIAL->value,
            RequestStatusEnum::ASSIGN_TO_BUYER->value,
        ];
        Project::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute(58940948533), [
            'settings' => [
                'supply' => [
                    'pre_request_code' => $preRequestCode,
                    'status' => [
                        'first_status' => $firstStatus,
                        'last_status' => $lastStatus,
                        'between_statuses' => $betweenStatuses
                    ],
                ],
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.not_found')
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_settings_when_first_status_is_wrong()
    {
        $preRequestCode = '543';
        $firstStatus = 45893249483948394;
        $lastStatus = RequestStatusEnum::SUPPLY->value;
        $betweenStatuses = [
            RequestStatusEnum::ACCEPT_FINANCIAL->value,
            RequestStatusEnum::ASSIGN_TO_BUYER->value,
        ];
        $project = Project::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($project->id), [
            'settings' => [
                'supply' => [
                    'pre_request_code' => $preRequestCode,
                    'status' => [
                        'first_status' => $firstStatus,
                        'last_status' => $lastStatus,
                        'between_statuses' => $betweenStatuses
                    ],
                ],
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'settings.supply.status.first_status' => [
                    __('validation.exists', ['attribute' => 'settings.supply.status.first status'])
                ]
            ]
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_settings_when_last_status_is_wrong()
    {
        $preRequestCode = '543';
        $firstStatus = RequestStatusEnum::SUPPLY->value;
        $lastStatus = 239879823141243;
        $betweenStatuses = [
            RequestStatusEnum::ACCEPT_FINANCIAL->value,
            RequestStatusEnum::ASSIGN_TO_BUYER->value,
        ];
        $project = Project::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($project->id), [
            'settings' => [
                'supply' => [
                    'pre_request_code' => $preRequestCode,
                    'status' => [
                        'first_status' => $firstStatus,
                        'last_status' => $lastStatus,
                        'between_statuses' => $betweenStatuses
                    ],
                ],
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'settings.supply.status.last_status' => [
                    __('validation.exists', ['attribute' => 'settings.supply.status.last status'])
                ]
            ]
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_update_settings_when_between_statuses_is_wrong()
    {
        $preRequestCode = '543';
        $firstStatus = RequestStatusEnum::SENT->value;
        $lastStatus = RequestStatusEnum::ACCEPT->value;
        $betweenStatuses = [
            23987341297143,
            RequestStatusEnum::ASSIGN_TO_BUYER->value,
        ];
        $project = Project::factory()->create();

        $response = $this->actingAsSuperUser()->putJson($this->getRoute($project->id), [
            'settings' => [
                'supply' => [
                    'pre_request_code' => $preRequestCode,
                    'status' => [
                        'first_status' => $firstStatus,
                        'last_status' => $lastStatus,
                        'between_statuses' => $betweenStatuses
                    ],
                ],
            ],
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.validation'),
            'errors' => [
                'settings.supply.status.between_statuses.0' => [
                    __('validation.exists', ['attribute' => 'settings.supply.status.between_statuses.0'])
                ]
            ]
        ]);
    }

    private function getRoute(int $projectId)
    {
        return route('settings.v1.projects-settings', $projectId);
    }
}
