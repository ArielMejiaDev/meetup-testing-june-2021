<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class WelcomeNewUsersNotificationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_tests_a_new_user_with_invalid_data_cannot_get_welcome_email(): void
    {
        $response = $this->post(route('register'), [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function it_tests_a_new_user_get_welcome_email(): void
    {
        session()->setPreviousUrl('register');

        Notification::fake();

        $response = $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $password = $this->faker->password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect(route('dashboard'));

        Notification::assertSentTo([$user = User::query()->where('email', $email)->first()], NewUserNotification::class);

        /** @var MailMessage $mailMessage */
        Notification::assertSentTo(
            $user,
            function (NewUserNotification $notification, $channels) use ($user) {
                $mailMessage = $notification->toMail($user);
                $this->assertEquals("Bienvenido {$user->name} a Laravel en Español!", $mailMessage->salutation);
                $this->assertEquals('Bienvenido a Laravel en Español!', $mailMessage->introLines[0]);
                $this->assertEquals('Puedes ver tips y snippets para Laravel en nuestro blog', $mailMessage->introLines[1]);
                $this->assertEquals('Gracias por usar nuestra app', $mailMessage->outroLines[0]);
                $this->assertEquals('Ir al blog', $mailMessage->actionText);
                $this->assertEquals(route('blog'), $mailMessage->actionUrl);
                return $notification->user->name === $user->name;
            }
        );
    }
}
