<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function rooms()
    {
        return ChatRoom::all();
    }

    public function messages($roomId)
    {
        return ChatMessage::where('chat_room_id', $roomId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function newMessage(Request $request, $roomId)
    {
        $newMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'chat_room_id' => $roomId,
            'message' => $request->message,
        ]);

        $newMessage = ChatMessage::where('id', $newMessage->id)->with('user')->first();

        broadcast(new NewChatMessage($newMessage))->toOthers();

        return $newMessage;
    }
}
