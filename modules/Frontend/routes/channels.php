<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{type}.{id}', function (User $user, string $type, int $id) {
    return $user->type === $type && $user->getClient()->id === $id;
});
