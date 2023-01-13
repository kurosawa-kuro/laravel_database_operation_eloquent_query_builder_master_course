<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ExampleTest extends TestCase
{
    use RefreshDatabase;
    private function ddResponse($response)
    {
        if ($response->exception == null) {
            $contents = json_decode(($response->baseResponse->getContent()));

            if ($contents == null) {
                dd(null);
            }

            dd($contents);
        } else {
            dd($response->exception);
        }
    }
    public function setUp() :void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        User::factory()->count(5)->create();
        $response = $this->get('/api/tests');

//        $this->ddResponse($response);
        $response->assertStatus(200);
    }
}
