<?php

namespace Modules\Frontend\Notifications\Company;

use App\Models\Vacancy;
use App\Models\Volunteers\Volunteer;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VacancyApplied extends Notification implements ShouldQueue
{
    use Queueable;

    protected Vacancy $vacancy;

    protected Volunteer $volunteer;

    public function __construct(Vacancy $vacancy, Volunteer $volunteer)
    {
        $this->vacancy = $vacancy;
        $this->volunteer = $volunteer;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $name = $this->volunteer->name;
        $vacancyTitle = $this->vacancy->title;

        return (new MailMessage)
            ->line("Volunteer $name has applied your vacancy \"$vacancyTitle\".")
            ->action('See volunteer\'s account', route('frontend.volunteers.show', $this->volunteer->id));
    }
}
