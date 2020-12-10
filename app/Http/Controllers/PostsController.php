<?php

namespace App\Http\Controllers;

use App\Eloquent\Roles;
use App\Eloquent\Tags;
use App\Http\Requests\PostsValidationRequest;
use App\Http\Resources\PostResource;
use App\Eloquent\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $items = Posts::ignoreRequest(['perpage'])->filter()
                ->orderByDesc('id');

            $items = $items->paginate(request()->get('perpage'),['*'],'page');
            $collection = collect(PostResource::collection($items));
            $items = collect($items);
            $items['data'] = $collection;
            $items['code'] = 200;
            $items['message'] = "success";
            $items->forget('first_page_url');
            $items->forget('last_page_url');
            $items->forget('next_page_url');
            $items->forget('prev_page_url');
            $items->forget('path');
            return response()->json($items, 200);
        } catch (\Exception $e) {
            return response()->json(['data' => $e, 'message' => 'Error', 'code' => 500], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PostsValidationRequest $request)
    {
        try {
            $user = \Auth::user();
            if (!$user->can('create', Posts::class)) {
                return response()->json(['data' => false, 'message' => 'Forbidden', 'code' => 403], 403);
            }

            $item = new Posts();
            $item->title = $request->title;
            $item->description = $request->description;
            $item->user_id = $user->id;
            $item->save();

            Tags::checkTags($request->tags, $item->id);
            $result = collect([]);
            $result['data'] = PostResource::make($item);
            $result['code'] = 200;
            $result['message'] = "success";

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['data' => $e, 'message' => 'Error', 'code' => 500], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Posts $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts)
    {
        //
    }
}
