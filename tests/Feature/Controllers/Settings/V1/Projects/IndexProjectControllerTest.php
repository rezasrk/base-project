<?php

namespace Tests\Feature\Controllers\Settings\V1\Projects;

use App\Enum\RequestStatusEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class IndexProjectControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_projects_list_successfully()
    {
        $preRequestCode = '543';
        $firstStatus = RequestStatusEnum::SENT->value;
        $lastStatus = RequestStatusEnum::SUPPLY->value;
        $acceptFinancial = RequestStatusEnum::ACCEPT_FINANCIAL->value;
        $assignToBuyer = RequestStatusEnum::ASSIGN_TO_BUYER->value;
        $betweenStatuses = [
            $acceptFinancial,
            $assignToBuyer
        ];
        $project = Project::factory()->create([
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

        $response = $this->actingAsSuperUser()->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => __('title.project')]),
            'data' => [
                [
                    'id' => $project->id,
                    'title' => $project->project_title,
                    'settings' => [
                        'supply' => [
                            'pre_request_code' => $preRequestCode,
                            'status' => [
                                'first_status' => [
                                    'id' => $firstStatus,
                                    'value' => 'Sent'
                                ],
                                'last_status' => [
                                    'id' => $lastStatus,
                                    'value' => 'Supply'
                                ],
                                'between_statuses' => [
                                    [
                                        'id' => $assignToBuyer,
                                        'value' => "Assign To Buyer"
                                    ],
                                    [
                                        'id' => $acceptFinancial,
                                        'value' => "Accept Financial"
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_projects_list()
    {
        $response = $this->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.unauthenticated'),
        ]);
    }

    /** @test */
    public function authenticated_user_can_not_see_projects_list_when_user_has_not_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->getJson($this->getRoute());

        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
        $response->assertExactJson([
            'status' => 'error',
            'message' => __('messages.exceptions.access_denied'),
        ]);
    }

    private function getRoute()
    {
        return route('settings.v1.projects.index');
    }
}
