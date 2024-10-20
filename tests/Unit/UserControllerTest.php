<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Http\Controllers\AuthController;

class UserControllerTest extends TestCase
{

    public function test_user_can_be_created()
    {
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123',
        ];

        $controller = new AuthController();

        $request = new Request($data);

        $response = $controller->register($request);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

    }


}
