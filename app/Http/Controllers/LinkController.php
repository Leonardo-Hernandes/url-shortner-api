<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Models\Link;
use App\Models\Analytic;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function store(LinkRequest $request)
    {
        $user = auth()->user();
        
        try {
            $input = $request->validated();

            $link['from'] = $input['url'];
            $link['to'] = $input['identifier'] ? $input['identifier'] : $this->getRandomString();
            $link['user_id'] = $user['id'];
            $link['views'] = 0;

            $response = Link::create($link);

            return response()->json([
                'status' => 'Success',
                'message' => 'Link created!',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'status' => 'error',
                'message' => 'identifier has arleady registered'
            ]);
        }
    }

    public function update($id, LinkRequest $request) {
        $user = auth()->user();

        try {
            $input = $request->validated();

            $link = Link::where('id', $id)->where('user_id', $user['id'])->firstOrFail();
            $link['to'] = $input['identifier'] ? $input['identifier'] : $link['to'];
            $link['from'] = $input['url'];
            $link->save();

            return response()->json([
                'status' => 'Success',
                'message' => 'Link updated;'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Link has not found'
            ]);
        }
    }

    public function delete($id) {
        $user = auth()->user();

        if (!$id)
            return response()->json([
                'status' => 'error',
                'message' => 'Link has not found'
            ]);

        try {
            Link::where('id', $id)->where('user_id', $user['id'])->firstOrFail();

            Link::where('id', $id)->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Link deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Link has not found'
            ]);
        }
    }

    public function show($id, Request $request)
    {
        try {
            $link = Link::where('to', $id)->firstOrFail();
            $link['views'] = $link['views'] + 1;
            $link->save();
            
            $annalytic['ip'] = $request->ip();
            $annalytic['link_id'] = $link->id;
            $annalytic['user-agent'] = $request->header('user-agent');
            Analytic::create($annalytic);

            return redirect()->away($link->from);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Link has not found'
            ]);
        }
    }

    public function search($id)
    {
        $response = Link::where('user_id', $id)->get();

        return $response;
    }

    public function getRandomString()
    {
        $bytesResponse = random_bytes(4);
        $string = bin2hex($bytesResponse);

        return $string;
    }
}