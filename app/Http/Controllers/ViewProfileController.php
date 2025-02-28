<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Check connection status
        $connectionStatus = null;
        
        if (Auth::check()) {
            $connection = Connection::where(function($query) use ($user) {
                $query->where('user_id', Auth::id())
                    ->where('connected_user_id', $user->id);
            })->orWhere(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('connected_user_id', Auth::id());
            })->first();

            if ($connection) {
                $connectionStatus = [
                    'id' => $connection->id,
                    'status' => $connection->status,
                    'is_receiver' => $connection->connected_user_id === Auth::id()
                ];
            }
        }

        return view('profile.view', compact('user', 'connectionStatus'));
    }

    public function showOwn()
    {
        return $this->show(Auth::id());
    }
}