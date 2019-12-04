<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\User;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\StoreUser;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Список пользователей
     *
     * @return resource Вывод страницы со списком
     */
    public function index()
    {
    	$users = User::orderBy('id', 'desc')
            ->paginate(config('app.per_page'));
    	return view('user/index', ['users' => $users]);
    }

    /**
     * Добавление нового пользователя
     *
     * @return resource Вывод страницы добавления
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * Редактирование информации о пользователе
     *
     * @param  int $id ID пользователя
     * @return resource Вывод страницы редактирования
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user/edit', ['user' => $user]);
    }

    /**
     * Обновление информации о пользователе
     *
     * @param  array     $request Данные с формы
     * @param  int       $id ID пользователя
     * @return resource  Возврат на страницу со списком
     */
    public function update(UpdateUser $request, $id)
    {
        //Поступивший запрос прошел валидацию
        // Получаем данные
        $validated = $request->validated();
    	$user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $validated['password'];
	    $user->save();

        return Redirect::to("/users")->withSuccess(__('Success updated'));
    }

    /**
     * Сохранение нового пользователя
     *
     * @param  array $request Данные из формы, прошедшие StoreUser
     * @return resource Возврат на страницу со списком
     */
    public function store(StoreUser $request)
    {
        //Поступивший запрос прошел валидацию
        // Получаем данные
	    $validated = $request->validated();
        User::create($request->all());
        return Redirect::to("/users")->withSuccess(__('Success created'));
    }

    /**
     * Удаление пользователя
     * 
     * @param  int $id ID пользователя
     * @return string JSON ответ об успешном удалении
     */
    public function destroy($id)
    {
        User::destroy($id);
	    return response()->json(__('Successfully deleted'));
    }
}
