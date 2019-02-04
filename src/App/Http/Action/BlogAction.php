<?php

namespace App\Http\Action;

use Framework\Http\Request;
use Framework\Http\Response;

class BlogAction
{
    public function __invoke(Request $request)
    {
        $name = $request->getQueryParams()['name'] ?? 'ooops';
        return new Response("Hello, {$name}!", 200);
    }
}
