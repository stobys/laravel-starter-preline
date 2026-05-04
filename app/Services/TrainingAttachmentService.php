<?php

namespace App\Services;

use App\Models\Training;
use App\Models\TrainingAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TrainingAttachmentService
{
    public function storeUploadedFiles(
        Training $training,
        array $files,
        array $notes = [],
        ?int $uploadedBy = null,
        string $disk = 'local'
    ): Collection {
        $saved = collect();

        foreach ($files as $index => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $uuid = (string) Str::orderedUuid();
            $extension = $file->extension();
            $storedFilename = $extension ? "{$uuid}.{$extension}" : $uuid;

            $attachmentData = [
				'uploaded_by' => $uploadedBy,
				'uuid' => $uuid,
				'filename' => $file->getClientOriginalName(),
				'storage_disk' => $disk,
				// 'storage_path' => $path,
				'mime_type' => $file->getMimeType(),
				'size_bytes' => $file->getSize(),
				'hash_sha256' => hash_file('sha256', $file->getRealPath()),
				'note' => $notes[$index] ?? null,
			];

            $path = $file->storeAs(
                "trainings/{$training->id}",
                $storedFilename,
                $disk
            );
			$attachmentData['storage_path'] = $path;

            $saved->push(
                $training->attachments()->create($attachmentData)
            );
        }

        return $saved;
    }

    public function updateNotes(Training $training, array $notes, array $excludeIds = []): void
    {
        $attachments = $training->attachments()
            ->when($excludeIds, fn ($q) => $q->whereNotIn('id', $excludeIds))
            ->get();

        foreach ($attachments as $attachment) {
            $attachment->update([
                'note' => $notes[$attachment->id] ?? null,
            ]);
        }
    }

    public function softDeleteMany(Training $training, array $ids): void
    {
        if (empty($ids)) {
            return;
        }

        $training->attachments()
            ->whereIn('id', $ids)
            ->get()
            ->each
            ->delete();
    }
}
