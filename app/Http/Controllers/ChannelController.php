<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Repositories\ModelHelper as Model;
use App\Error\ErrorHandler;

class ChannelController extends Controller
{
    use ErrorHandler;
    /**
     * @var Repository ModelHelper
     */
    protected $model;
    /**
     * ChannelController constructor.
     *
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->model = new Model( $channel );
        // Protect all except reading
        $this->middleware('auth', ['except' => ['index', 'show'] ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model->with('user')->latest()->paginate();
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
        // run the validation
        $this->validateBeforeCreate($request);

        return $request->user()->channels()
            ->create( $request->only($this->model->getModel()->fillable));
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
        // validate the channel id belongs to user
        if( ! $request->user()->channels()->find($id) ) {
            return $this->errorForbidden('You can only edit your channel.');
        }
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
        if (! $request->user()->channels()->find($id)) {
            return $this->errorNotFound('Channel not found.');
        }
        return $this->model->delete($id) ? $this->noContent() : $this->errorBadRequest();
    }
}
