<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class WallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Message::orderByDesc('created_at')->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            if(!$user){
                return response()->json([
                    'message' => 'Пользователь неавторизован'
                ], 401);
            }

            $message = Message::create(['text' => $request->get('text'), 'user_id' => $user->id]);

            return response()->json([
                'message' => 'Сообщение успешно сохранено',
                'user_message' => $message
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Произошла ошибка'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        try {

            $user = Auth::user();

            if(!$user){
                return response()->json([
                    'message' => 'Пользователь неавторизован'
                ], 401);
            }

            if($message->user_id != $user->id) {
                return response()->json([
                    'message' => 'Данное сообщение не принадлежит пользователю'
                ], 400);
            }

            if(date_diff(new \DateTime(), $message->created_at)->days <= 0)
            {
                $message->delete();

                return response()->json([
                    'message' => 'Сообщение успешно удалено'
                ], 200);

            } else {
                return response()->json([
                    'message' => 'Прошло 24 часа после создания сообщения'
                ], 400);
            }

        } catch( \Throwable $th) {
            return response()->json([
                'message' => 'Произошла ошибка'
            ]);
        }
    }
}
