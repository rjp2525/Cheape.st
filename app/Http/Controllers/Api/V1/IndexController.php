<?php

namespace Cheapest\Http\Controllers\Api\V1;

use Cheapest\Http\Controllers\Controller;
use Cheapest\Http\Requests;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Return a generic response for now.
     * TODO: Turn this into some API docs or something?
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(['error' => true, 'message' => 'Invalid API token']);
    }
}
