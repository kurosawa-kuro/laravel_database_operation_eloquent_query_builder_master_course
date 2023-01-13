<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function test()
    {
        $users = User::get()->toJson(JSON_PRETTY_PRINT);

        return response($users, Response::HTTP_OK);
    }
}
