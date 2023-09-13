<?php

namespace Tests\Feature\Controllers;

use App\Models\Baseinfo;
use Illuminate\Http\JsonResponse;
use Tests\Feature\BaseFeatureTestCase;

final class BaseinfoControllerTest extends BaseFeatureTestCase
{
    /** @test */
    public function authenticated_user_can_see_baseinfo_information()
    {
        $firstBaseType = 'firstBaseType';
        $firstBaseValue = 'firstBaseValue';
        $baseinfo = Baseinfo::factory()->create([
            'type' => $firstBaseType,
            'value' => $firstBaseValue,
            'parent_id' => 1233
        ]);

        $response = $this->actingAsSuperUser()->getJson($this->getRoute() . '?types=' . $firstBaseType);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => 'baseinfo']),
            'data' => [
                $firstBaseType => [
                    [
                        'id' => $baseinfo->id,
                        'value' => $baseinfo->value
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function authenticated_user_can_see_multiple_baseinfo_information()
    {
        $firstBaseType = 'firstBaseType';
        $firstBaseValue = 'firstBaseValue';
        $firstBaseinfo = Baseinfo::factory()->create([
            'type' => $firstBaseType,
            'value' => $firstBaseValue,
            'parent_id' => 1233
        ]);
        $secondBaseType = 'secondBaseType';
        $secondBaseValue = 'secondBaseValue';
        $secondBaseinfo = Baseinfo::factory()->create([
            'type' => $secondBaseType,
            'value' => $secondBaseValue,
            'parent_id' => 1233
        ]);


        $response = $this->actingAsSuperUser()->getJson($this->getRoute() . '?types=' . $firstBaseType . ',' . $secondBaseType);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertExactJson([
            'status' => 'success',
            'message' => __('messages.fetch', ['title' => 'baseinfo']),
            'data' => [
                $firstBaseType => [
                    [
                        'id' => $firstBaseinfo->id,
                        'value' => $firstBaseinfo->value
                    ]
                ],
                $secondBaseType => [
                    [
                        'id' => $secondBaseinfo->id,
                        'value' => $secondBaseinfo->value
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_see_baseinfo_information()
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
        return route('baseinfo');
    }
}
