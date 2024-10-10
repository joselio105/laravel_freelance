<?php

namespace App\Livewire\Proposals;

use App\Models\Project;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public bool $modal = true;

    public Project $project;

    #[Rule(['required', 'email'])]
    public string $email = '';

    #[Rule(['required', 'numeric', 'min:1'])]
    public int $hours = 0;

    public bool $agree = false;

    public function save()
    {
        if (!$this->agree) {
            $this->addError('agree', 'Você precisa concordar com os termos de uso');

            return;
        }
        $this->validate();

        $this->project->proposals()->updateOrCreate(
            ['email' => $this->email],
            ['hours' => $this->hours],
        );
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.proposals.create');
    }
}
