<?php

namespace App\Models;

use App\Models\Chats\Chat;
use App\Models\Chats\Message;
use App\Models\Interfaces\SearchRecordable;
use App\Models\Traits\SearchRecording;
use App\Models\Volunteers\Volunteer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Client extends Model implements SearchRecordable
{
    use SearchRecording;

    public function getUnviewedMessages(): int
    {
        return $this->incomeMessages()->unviewed()->count();
    }

    /* @return Message|HasManyThrough */
    public function incomeMessages(): HasManyThrough
    {
        return $this->hasManyThrough(Message::class, Chat::class)
            ->whereNull($this instanceof Volunteer ? 'chat_messages.volunteer_id' : 'chat_messages.company_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
