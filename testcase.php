use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Notification;

public function test_event_is_dispatched(): void
{
    Event::fake();

    $this->post('/users', [...]);

    Event::assertDispatched(UserRegistered::class);
}

public function test_job_is_pushed(): void
{
    Queue::fake();

    $this->post('/orders', [...]);

    Queue::assertPushed(ProcessOrder::class);
}

public function test_notification_is_sent(): void
{
    Notification::fake();

    $user = User::factory()->create();
    $this->actingAs($user)->post('/orders', [...]);

    Notification::assertSentTo($user, OrderPlaced::class);
}


<?php

use App\Models\User;

it('can create a user', function () {
    $response = $this->post('/users', [
        'name' => 'John',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/users');
    expect(User::count())->toBe(1);
});

it('requires authentication', function () {
    $this->get('/dashboard')->assertRedirect('/login');
})->throwsNoExceptions();

// In test
$users = User::factory()->count(5)->create();
$admin = User::factory()->admin()->create();
$inactive = User::factory()->create(['active' => false]);

// database/factories/UserFactory.php
public function definition(): array
{
    return [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => bcrypt('password'),
    ];
}

public function admin(): static
{
    return $this->state(fn (array $attributes) => [
        'role' => 'admin',
    ]);
}

public function test_api_returns_users_list(): void
{
    User::factory()->count(3)->create();

    $response = $this->getJson('/api/users');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email'],
            ],
        ]);
}

public function test_api_creates_user(): void
{
    $response = $this->postJson('/api/users', [
        'name' => 'Jane',
        'email' => 'jane@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(201)
        ->assertJson(['data' => ['email' => 'jane@example.com']]);
}



public function test_email_is_required(): void
{
    $response = $this->post('/users', [
        'name' => 'John',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertDatabaseCount('users', 0);
}

public function test_email_must_be_valid(): void
{
    $response = $this->post('/users', [
        'name' => 'John',
        'email' => 'not-an-email',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
}

public function test_user_can_login(): void
{
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
}

public function test_guest_cannot_access_dashboard(): void
{
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
}

public function test_authenticated_user_can_access_dashboard(): void
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
}