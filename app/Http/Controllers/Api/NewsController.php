<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use App\Models\Comments;
use App\Models\LogsNews;
use App\Events\NewsCreated;
use App\Events\NewsDeleted;
use App\Events\NewsUpdated;
use Illuminate\Http\Request;
use App\Jobs\CreateCommentJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(News::class, 'news');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = QueryBuilder::for(News::class)
            ->defaultSort('-created_at')
            ->allowedSorts(['title', 'content'])
            ->allowedIncludes(['user'])
            ->with(['user'])
            ->paginate();

        $news = News::with('comments.user')->get();
        return response()->json([
            'data'    => NewsResource::collection($news),
            'message' => 'Retrievied Successfully'
        ], 200);
        // return response()->json([
        //     'data'    => News::with(['user'])->first(),
        //     'message' => 'Retrievied Successfully'
        // ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $data = $request->validated();

        if ($request->hasfile('image')) {
            $extFile = $request->file('image')->getClientOriginalExtension();
            // $nameFile = 'spa' . time() . '.' . $extFile;
            $nameFile = $request->file('image')->getClientOriginalName();

            $image = $request->file('image')->move('images/', $nameFile);

            $data['image']      = $image;
        }

        $news = Auth::user()->news()->create($data);
        event(new NewsCreated($news));


        return response()->json([
            'data'    => (new NewsResource($news))->load('user'),
            'message' => 'News has been created by: ' . Auth::user()->name,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        // return new NewsResource($news);
        $news = News::with('user', 'comments.user')->findOrFail($news->id);
        return new NewsResource($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $data = $request->validated();
        // $n = Auth::user()->news()->update($data);

        $existingFileName = $news->image;
        if ($existingFileName && file_exists(public_path($existingFileName))) {
            unlink(public_path($existingFileName));
        }

        if ($request->hasFile('image')) {
            $extFile = $request->file('image')->getClientOriginalExtension();
            // $nameFile = 'spa' . time() . '.' . $extFile;
            $nameFile = $request->file('image')->getClientOriginalName();

            $image = $request->file('image')->move('images/', $nameFile);

            $data['image']      = $image;
            $news->update($data);
        }

        $news->update($data);
        event(new NewsUpdated($news));

        return response()->json([
            'data'    => (new NewsResource($news))->load('user'),
            'message' => 'News has been update by: ' . Auth::user()->name,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $existingFileName = $news->image;
        if ($existingFileName && file_exists(public_path($existingFileName))) {
            unlink(public_path($existingFileName));
        }

        $news->delete();
        event(new NewsDeleted($news));

        return response()->json([
            'message' => 'news has been deleted'
        ], 200);
    }

    public function storeComments(Request $request, News $news)
    {

        $data = $request->validate([
            'comment' => ['required', 'string'],
        ]);

        $data['user_id'] = Auth::user()->id;

        $comment = $news->comments()->create($data);
        CreateCommentJob::dispatch($data);

        return response()->json([
            'data' =>$comment,
            'message' => 'comments has been created'
        ], 200);
    }
}
