<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Video;
use App\Repositories\ModelHelper as Model;
use App\Error\ErrorHandler;



class VideoController extends Controller
{

    /**
     * Error Handler Trait
     */
    use ErrorHandler;

    /**
     * VideoController constructor.
     *
     * @param Video $video
     */

    protected $model;

    public function __construct(Video $video)
    {
        $this->model = new Model($video);

        // Protect all except reading
        $this->middleware('auth', ['except' => ['index', 'show'] ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $this->model->with(['channel']);

        // check for trending
        if ( $request->has('trending')) {
            $query->orderBy('views', 'desc');
        }

        // paginate the result
        $paginated = $query->latest()->paginate()->toArray();

        // check for categories
        if ($request->has('categories')) {
            $paginated['categories'] = Category::select('id', 'name')->get();
        }

        return $paginated;
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
        //run the validation befor create new video
        $this->validateBeforeCreate($request);

        // validate the channel id belongs to user
        if( ! $request->user()->channels()->find($request->get('channel_id', 0)) )
            return $this->errorForbidden('You can only add video in your channel.');


        return $request->user()
            ->videos()->create(
                $request->only(
                    $this->model
                    ->getModel()
                    ->fillable
                )
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->model->with('user')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateBeforeUpdate($request);

        if (! $this->model->update($request->only($this->model->getModel()->fillable), $id) ) {
            return $this->errorBadRequest('Unable to update.');
        }
        return $this->model->find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // run before delete checks
        if (! $request->user()->videos()->find($id)) {
            return $this->errorNotFound('Video not found.');
        }
        return $this->model->delete($id) ? $this->noContent() : $this->errorBadRequest();
    }
}
