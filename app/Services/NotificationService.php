<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Notification;

class NotificationService
{
    public function query($with_filter = false) {
        return auth()->user()->notifications();
        // Notification::query()->whereUserId(auth()->id());
    }

    public function getLatest()
    {
        return $this->query()->limit(5)->get();
    }

    // -- passing validated $data from controller to service
    public function store($data)
    {
        $model = Notification::create($data);

        return [
            'errno' => $model->exists ? 0 : 1,
            'errmsg' => $model->exists ? 'Provider saved successfully' : 'Provider not saved',
            'model' => $model
        ];
    }

    // -- mark as read
    public function markAsRead($model = null)
    {
        if( ! $model instanceof Notification ) {
            $model = Notification::findOrFail($model);
        }

        return $model -> update([
            'read_at' => now(),
            'read_by' => auth()->id(),
        ]);
    }

    // -- mark as unread
    public function markAsUnread($model = null)
    {
        if( ! $model instanceof Notification ) {
            $model = Notification::findOrFail($model);
        }

        return $model -> update([
            'read_at' => null,
            'read_by' => null,
        ]);
    }

    public function toggleRead($model = null)
    {
        if( ! $model instanceof Notification ) {
            $model = Notification::findOrFail($model);
        }

        if ( $model->read_at ) {
            return $this->markAsUnread($model);
        }
        else {
            return $this->markAsRead($model);
        }

    }

    public function getExportFileName()
    {
        $baseName = Str::studly(Notification::getTableName());
        return sprintf('%s-%s.csv', $baseName, now()->format('YmdHis'));
    }
}
