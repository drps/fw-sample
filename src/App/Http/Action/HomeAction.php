<?php

namespace App\Http\Action;

use Framework\Http\Request;
use Framework\Http\Response;

class HomeAction
{
    public function __invoke(Request $request)
    {
        return new Response("<a href='/blog/24?name=sasa'>Blog/24</a>");
    }
}
