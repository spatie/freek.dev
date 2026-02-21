<?php

namespace App\Livewire;

use App\Livewire\Forms\TestimonialForm as TestimonialFormObject;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestimonialForm extends Component
{
    use WithFileUploads;

    public TestimonialFormObject $form;

    public function save(): void
    {
        $this->form->validate();

        $key = 'testimonial-submission:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 15)) {
            $this->addError('form.text', 'You have submitted too many recommendations. Please try again later.');

            return;
        }

        $this->form->store();

        RateLimiter::hit($key, 3600);

        $this->redirect('/newsletter/recommend/thanks', true);
    }

    public function render()
    {
        return view('livewire.testimonial-form');
    }
}
