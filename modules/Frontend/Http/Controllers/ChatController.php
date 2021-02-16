<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Chats\Chat;
use App\Models\Chats\Message;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Frontend\Events\NewMessage;

class ChatController extends Controller
{
    public function page(Chat $chat = null)
    {
        $this->seo()->setTitle('Chat');

        $user = \Auth::user();
        $client = $user->getClient();

        $with = [$user->is_volunteer ? 'company.logoMedia' : 'volunteer.avatarMedia'];

        $chats = $client->chats()->with(['vacancy', ...$with])->get();

        $chats = $chats->map(function (Chat $chat) use ($user, $client) {
            $receiver = $chat->relationLoaded('volunteer') ? $chat->volunteer : $chat->company;
            $receiver->append(['icon', 'name']);
            /* @var $lastMessage Message */
            $lastMessage = $chat->messages()->latest()->first();
            $id = $client->id;
            if ($user->is_volunteer ? $id === $lastMessage->volunteer_id : $client->id === $lastMessage->company_id) {
                $lastMessage->isOwner = true;
            }

            return [
                'id' => $chat->id,
                'jobTitle' => $chat->vacancy->title ?? null,
                'name' => $receiver->name,
                'avatar' => $receiver->icon,
                'lastMessage' => $this->mapMessage($lastMessage)
            ];
        });

        share(compact('chats'));

        if ($chat) {
            $this->markMessagesAsViewed($client, $chat);
            share([
                'selectedChatId' => $chat->id,
                'messages' => $chat->messages->map(fn(Message $message) => $this->mapMessage($message)),
                'unviewedMessages' => $client->getUnviewedMessages()
            ]);
        }

        return view('frontend::pages.chat');
    }

    protected function mapMessage(Message $message): array
    {
        $user = \Auth::user();
        $client = $user->getClient();
        $data = $message->toArray();
        $data['isOwner'] = $user->is_volunteer
            ? $message->volunteer_id === $client->id
            : $message->company_id === $client->id;
        return $data;
    }

    protected function markMessagesAsViewed(Client $client, Chat $chat)
    {
        $client->setRelation('chats', [$chat])->incomeMessages()->unviewed()->update(['is_viewed' => true]);
    }

    public function messages(Chat $chat): JsonResponse
    {
        $client = \Auth::user()->getClient();
        $messages = collect();

        $this->markMessagesAsViewed($client, $chat);
        $messages = $chat->messages->map(function (Message $message) {

            return $this->mapMessage($message);
        });

        return response()->json([
            'messages' => $messages,
            'unviewedMessages' => $client->getUnviewedMessages()
        ]);
    }

    public function send(Request $request, Chat $chat): JsonResponse
    {
        $request->validate([
            'message' => ['required', 'string', 'max:510']
        ]);
        $user = \Auth::user();
        /* @var $message Message */
        $message = $user->getClient()->messages()->create([
            'chat_id' => $chat->id,
            'text' => $request->message
        ]);

        broadcast(new NewMessage($message, $chat, $user->getClient()));

        return response()->json(['message' => $this->mapMessage($message)], 201);
    }
}
