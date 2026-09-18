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


