<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'chat_messages';

    protected $fillable = ['chat_id', 'volunteer_id', 'company_id', 'text', 'is_viewed'];

    public function markAsViewed(): bool
    {
        $this->is_viewed = true;
        return $this->save();
    }

    public function scopeUnviewed(Builder $builder): void
    {
        $builder->where('is_viewed', '=', false);
    }
}
