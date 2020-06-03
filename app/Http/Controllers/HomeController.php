<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpJunior\LaravelVideoChat\Facades\Chat;
use PhpJunior\LaravelVideoChat\Models\File\File;
use PhpJunior\LaravelVideoChat\Models\Conversation\Conversation;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Chat::getAllGroupConversations();
        $threads = Chat::getAllConversations();
        
        
        
       $newCollection = $threads->map(function($value,$key) {
        return   $value->user->id ;
});

       
        $users = User::where('id', '!=', auth()->id())->get();

        return view('home')->with([
            'threads' => $threads,
            'groups'  => $groups,
            'users'=>$users
        ]);
    }

    
    public function start($id){
       
        $conversation = Conversation::updateOrCreate(['first_user_id'=>Auth::id(),'second_user_id'=>$id]);
        $conversation->save();

        $conversation->messages()->updateOrCreate([
            'user_id'   => Auth::id(),
            'text'      => 'Hello'
        ]);
        return redirect()->back();
    }
    
    public function chat($id)
    {
        $conversation = Chat::getConversationMessageById($id);

        return view('chat')->with([
            'conversation' => $conversation
        ]);
    }

    public function groupChat($id)
    {
        $conversation = Chat::getGroupConversationMessageById($id);

        return view('group_chat')->with([
            'conversation' => $conversation
        ]);
    }

    public function send(Request $request)
    {
        Chat::sendConversationMessage($request->input('conversationId'), $request->input('text'));
    }

    public function groupSend(Request $request)
    {
        Chat::sendGroupConversationMessage($request->input('groupConversationId'), $request->input('text'));
    }

    public function sendFilesInConversation(Request $request)
    {
        Chat::sendFilesInConversation($request->input('conversationId') , $request->file('files'));
    }

    public function sendFilesInGroupConversation(Request $request)
    {
        Chat::sendFilesInGroupConversation($request->input('groupConversationId') , $request->file('files'));
    }
}
