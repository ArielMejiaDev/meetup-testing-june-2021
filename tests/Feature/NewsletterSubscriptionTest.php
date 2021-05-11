<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Newsletter as SpatieNewsletterFacade;
use Spatie\Newsletter\Newsletter;
use Tests\TestCase;

class NewsletterSubscriptionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_tests_an_invalid_email_cannot_be_added_to_newsletter(): void
    {
        session()->setPreviousUrl(route('welcome'));

        $response = $this->post(route('newsletter.store'), [
            'email' => '',
        ]);

        $response->assertRedirect(route('welcome'))
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_tests_a_valid_email_can_be_added_to_newsletter(): void
    {
        $email = $this->faker->email;

        session()->setPreviousUrl(route('welcome'));

        $this->mock(Newsletter::class, function (MockInterface $mock) use ($email) {
            $mock->shouldReceive('subscribe')->once()->with($email)->andReturnNull();
        });

        $response = $this->post(route('newsletter.store'), ['email' => $email]);

        $response->assertRedirect(route('welcome'));
    }

    /** @test */
    public function it_tests_a_valid_email_can_be_added_to_newsletter_api(): void
    {
        $email = $this->faker->email;

        session()->setPreviousUrl(route('welcome'));

        SpatieNewsletterFacade::shouldReceive('subscribe')
            ->once()
            ->with($email)
            ->andReturnNull();

        $response = $this->postJson(route('api.newsletter.store'), ['email' => $email]);

        $response->assertRedirect(route('welcome'));
    }
}
