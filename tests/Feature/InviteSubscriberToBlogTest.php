<?php

namespace Tests\Feature;

use App\Mail\InviteSubscriberToBlogMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Spatie\Newsletter\Newsletter;
use Tests\TestCase;

class InviteSubscriberToBlogTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private string $email;

    public function setUp(): void
    {
        parent::setUp();

        $this->email = $this->faker->email;
    }

    /** @test */
    public function it_tests_a_newsletter_cannot_store_an_invalid_email(): void
    {
        session()->setPreviousUrl($route = route('welcome'));

        $response = $this->post(route('newsletter.store'), [
            'email' => $this->faker->name,
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_tests_a_newsletter_cannot_store_a_request_with_honeypot_field_present(): void
    {
        session()->setPreviousUrl($route = route('welcome'));

        $response = $this->post(route('newsletter.store'), [
            'email' => $this->email,
            'hp_newsletter' => $this->faker->name
        ]);

        $response->assertSessionHasErrors('hp_newsletter');
    }

    /** @test */
    public function it_tests_a_newsletter_subscriber_get_email_notification(): void
    {
        Mail::fake();

        session()->setPreviousUrl($route = route('welcome'));

        $this->mock(Newsletter::class, function (MockInterface $mock) {
            $mock->shouldReceive('subscribe')->once()->with($this->email)->andReturnNull();
        });

        $response = $this->post(route('newsletter.store'), [
            'email' => $this->email,
        ]);

        $response->assertRedirect($route);

        Mail::assertSent(InviteSubscriberToBlogMail::class);
        Mail::assertSent(InviteSubscriberToBlogMail::class, fn ($mail) => $mail->hasTo($this->email));
        Mail::clearResolvedInstance(InviteSubscriberToBlogMail::class);
    }

    /** @test */
    public function it_tests_newsletter_subscriber_mailable_content(): void
    {
        $mailable = new InviteSubscriberToBlogMail();
        $mailable->assertSeeInHtml('Bienvenido!');
        $mailable->assertSeeInText('Gracias por subscribirte al newsletter, puedes ingresar a nuestro blog para ver tips y snippets en Laravel.');
        $mailable->assertSeeInHtml(route('blog'));
    }
}
