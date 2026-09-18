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