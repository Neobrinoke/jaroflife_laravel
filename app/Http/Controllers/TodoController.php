<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Task;
use App\User;
use App\TodosUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class TodoController
 * @package App\Http\Controllers
 */
class TodoController extends Controller
{
	/**
	 * TodoController constructor.
	 */
	public function __construct()
	{
		$this->middleware( 'auth' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view( 'todo.index', ['todos' => Auth::user()->todos] );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( Request $request )
	{
		$validate_data = $request->validate( ['name' => 'required|string|max:255|min:4', 'description' => 'required|string|max:255|min:10'] );
		$validate_data['author_id'] = Auth::id();

		$todo = Todo::create( $validate_data );

		TodosUser::create( ['user_id' => Auth::id(), 'todo_id' => $todo->id, 'authority_id' => 1] );

		return redirect()->route( 'todo.index' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Todo $todo
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function show( Todo $todo )
	{
		$this->authorize( 'show_todo', $todo );

		$title = "Mes tâches pour la liste [$todo->name]";

		return view( 'todo.show', compact( 'todo', 'title' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Todo $todo
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function edit( Todo $todo )
	{
		$this->authorize( 'edit_todo', $todo );

		$title = "Détails de la liste [$todo->name]";
		$users = User::findAllWithoutMe();

		return view( 'todo.edit', compact( 'todo', 'title', 'users' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param Todo    $todo
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function update( Request $request, Todo $todo )
	{
		$this->authorize( 'edit_todo', $todo );

		$validate_data = $request->validate( ['name' => 'required|string|max:255|min:4', 'description' => 'required|string|max:255|min:10'] );

		$todo->fill( $validate_data );
		$todo->save();

		return redirect()->route( 'todo.edit', compact( 'todo' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Todo $todo
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function destroy( Todo $todo )
	{
		$this->authorize( 'edit_todo', $todo );

		TodosUser::where( 'todo_id', $todo->id )->delete();
		Task::where( 'todo_id', $todo->id )->delete();

		return redirect()->route( 'todo.index' );
	}

	/**
	 * Add some collabs on the todo.
	 *
	 * @param Request $request
	 * @param Todo    $todo
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function addCollab( Request $request, Todo $todo )
	{
		$this->authorize( 'edit_todo', $todo );

		$users_id = explode( ',', $request->input( 'users' ) );
		foreach( $users_id as $user_id )
		{
//			$todo_user = TodosUser::findByTodoAndUserUnsec( $todo->id, $user_id );
//			if( $todo_user == null )
//			{
				TodosUser::create( ['user_id' => $user_id, 'todo_id' => $todo->id, 'authority_id' => 3] );
//			}
		}

		return redirect()->route( 'todo.edit', compact( 'todo' ) );
	}

	/**
	 * Update the collab info for this todo.
	 *
	 * @param Request $request
	 * @param Todo    $todo
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function editCollab( Request $request, Todo $todo )
	{
		$this->authorize( 'edit_todo', $todo );

		$todo_user = TodosUser::findByTodoAndUser( $todo->id, $request->input( 'user_id' ) );
		if( $request->has( 'edit_member' ) )
		{
			$todo_user->authority_id = $request->input( 'authority_id' );
			$todo_user->save();
		}
		else $todo_user->delete();

		return redirect()->route( 'todo.edit', compact( 'todo' ) );
	}
}
