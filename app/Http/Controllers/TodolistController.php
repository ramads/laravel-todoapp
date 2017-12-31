<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TodoList;
use Cache;

class TodolistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // mengecek query
        // \DB::enableQueryLog();
        // menggunakan cache untuk menyimpan hasil query
        // $todoLists = Cache::remember('datalist', 1, function() use ($request){
        //     return $request->user()
        //                 ->todoLists()
        //                 ->orderBy('updated_at', 'desc')
        //                 ->with('tasks')
        //                 ->get();
        // });
        // view('todoapp.index', compact('todoLists'))->render();
        //
        // dd(\DB::getQueryLog());

        $todoLists = $request->user()
                        ->todoLists()
                        ->orderBy('updated_at', 'desc')
                        ->with('tasks')
                        ->get();
        return view('todoapp.index', compact('todoLists'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $todolist = new TodoList();
            return view('todoapp.todolist-form', compact('todolist'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required'
        ]);

        $tl = $request->user()->todoLists()->create($request->all());

        return view('todoapp.item', compact('tl'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $todolist = $request->user()->todoLists()->findOrFail($id);
        $tasks = $todolist->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $todolist = TodoList::find($id);
            return view('todoapp.todolist-form', compact('todolist'));
        }
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
        $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required'
        ]);

        $tl = TodoList::findORFail($id);
        $tl->update($request->all());
        return view('todoapp.item', compact('tl'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $todolist = TodoList::find($id);
        $todolist->delete();
        return redirect('app')->with('message', 'Data deleted!');
    }
}
