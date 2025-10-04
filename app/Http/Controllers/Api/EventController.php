<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
    public function index(){
        $events = Event::latest()->paginate(10);
        return response()->json([
            "response" => [
                'status' => 200,
                "message" => 'List Data Event'
            ], "data" => $events
        ], 200);
    }

    public function show($slug){
        $event = Event::where('slug', $slug)->first();
        if($event){
            return response()->json([
                "response" => [
                    'status' => 200,
                    'message' => 'Detail Data Agenda'
                ], "data" => $event
            ], 200);
        }else{
            return response()->json([
                "response" => [
                    'status' => 404,
                    'message' => 'Data Agenda tidak ditemukan'
                ],
                "data" => null
            ], 404);
        }
    }

    public function EventHomePage(){
        $events = Event::latest()->take(5)->get();
        return response()->json([
            "response" => [
                "status" => 200,
                "message" => "List Data Agenda HomePage"
            ], "data" => $events
        ], 200);
    }
}
