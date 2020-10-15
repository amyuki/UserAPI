<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use Tests\TestCase;


class UserControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testSearch()
    {
        $users = User::factory()->count(5)->create(['firstname' => 'Mac']);
        Passport::actingAs($users[0]);
        $response1 = $this->json('GET', 'api/user/search', [
            'firstname' => 'Mac'
        ]);
        $response1->assertStatus(200);
        $this->assertEquals(5, $response1->decodeResponseJson()['data']['total']);

        $response2 = $this->json('GET', 'api/user/search', [
            'lastname' => $users[2]->lastname,
            'phone' => $users[2]->phone,
        ]);
        $response2->assertStatus(200);
        $this->assertEquals(1, $response2->decodeResponseJson()['data']['total']);

        $response3 = $this->json('GET', 'api/user/search', [
            'lastname' => $users[2]->lastname,
            'email' => $users[4]->email,
        ]);
        $response3->assertStatus(200);
        $this->assertEquals(0, $response3->decodeResponseJson()['data']['total']);
    }

    public function testCreateUser()
    {
        $response = $this->json('POST', 'api/user/create', [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'password' => $this->faker->password,
        ]);
        $response->assertStatus(200);

    }

    public function testLogin()
    {
        $user = User::factory()->create();
        $response = $this->json('POST', 'api/user/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $new_lastname = $this->faker->lastName;
        $response = $this->json('PUT', 'api/user/' . $user->id, [
            'lastname' => $new_lastname,
        ]);
        $response->assertStatus(200);
        $this->assertEquals($new_lastname, $response->decodeResponseJson()['data']['user']['lastname']);
    }

    public function testView()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->json('GET', 'api/user/' . $user->id);
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $user = User::factory()->create();
        $rootuser = User::factory()->create(['is_admin' => true]);
        Passport::actingAs($rootuser);
        $response = $this->json('DELETE', 'api/user/' . $user->id);
        $response->assertStatus(200);
    }

    public function testUploadAvatar()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $file = UploadedFile::fake()->image($this->faker->word . '.jpg');
        $response = $this->json('POST', 'api/user/avatar', [
            'avatar' => $file
        ]);
        $response->assertStatus(200);
        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }

}
