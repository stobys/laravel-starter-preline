<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Training;
use Livewire\WithFileUploads;
use App\Services\TrainingService;
use Livewire\Attributes\Validate;
use App\Models\TrainingAttachment;
use Illuminate\Support\Facades\Storage;

class TrainingAttachmentsComponent extends Component
{
    use WithFileUploads;

    protected $service;
    public $training_id;

    public function fetchTraining()
    {
        return Training::find($this->training_id);
    }

    #[Validate(['attachments.*' => 'file|mimes:png,jpg,pdf|max:20480'])]
    // #[Validate('file|mimes:png,jpg,pdf|max:20480')] // 20 MB
    public $attachments = [];

    public function mount(Training $training)
    {
        $this->training_id = $training->id;
    }

    public function boot(TrainingService $service)
    {
        $this->service = $service;
    }

    public function updatedFiles()
    {
        $this->validate();
    }

    // public function removeByIndex(int $index): void
    // {
    //     if (! isset($this->attachments[$index])) return;

    //     unset($this->attachments[$index]);
    //     $this->attachments = array_values($this->attachments);
    // }

    // Usuń element z listy (i z temp)
    public function removeItem(int $index): void
    {
        if (!isset($this->attachments[$index])) return;

        // _removeUpload('property', 'tmpFilename') czyści fizyczny plik z livewire-tmp
        // Gdy mamy obiekt TemporaryUploadedFile, możemy użyć getFilename():
        if (method_exists($this->attachments[$index], 'getFilename')) {
            $this->_removeUpload('attachments', $this->attachments[$index]->getFilename());
        }

        // usuń z tablicy stanu
        // unset($this->attachments[$index]);
        // reindeksacja, aby Blade foreach i indeksy pozostały spójne
        // $this->attachments = array_values($this->attachments);
    }

    public function save()
    {
        $this->validate();

        $stored = $this->service->setTrainingId($this->training_id)->saveAttachments($this->attachments);

        // opcjonalnie: reset pola
        $this->reset('attachments');

        // flash/info
        // session()->flash('status', 'Plik zapisany: '. $paths);
        // Tu możesz zapisać metadane do DB, np. $stored ścieżki
        session()->flash('status', 'Zapisano: '.count($stored).' plików.');
    }

    public function render()
    {
        return view('livewire.training-attachments');
    }

    public function deleteAttachment($uuid)
    {
        $attachment = TrainingAttachment::where('uuid', $uuid)->first();

        // $this->authorize('delete-attachment', $attachment);

        if( $attachment->delete() ) {
            Storage::disk($attachment->storage_disk)->delete($attachment->storage_path);
        }

        return true;
    }

}
