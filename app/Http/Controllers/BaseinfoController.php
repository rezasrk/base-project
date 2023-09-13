<?php

namespace App\Http\Controllers;

use App\Services\Actions\BaseinfoService;
use Illuminate\Http\Request;

/**
 * @group Settings
 *
 * @authenticated
 */
class BaseinfoController extends Controller
{
    /**
     * Baseinfo list
     * Valid type "request_status,request_type"
     * 
     * @queryParam type Example: request_type,request_stats
     *
     * @response{
     *   "status":"success",
     *   "message":"Baseinfo fetch successfully",
     *   "data":[
     *      "request_statuses":[
     *          {
     *              "id":23,
     *              "value":"Sent"
     *          }
     *      ]    
     *   ]
     * }
     */
    public function __invoke(Request $request, BaseinfoService $baseinfoService)
    {
        $baseinfo = $baseinfoService->handle(
            explode(',', $request->query('types'))
        );

        return response()->success(__('messages.fetch', ['title' => 'baseinfo']), $baseinfo);
    }
}
