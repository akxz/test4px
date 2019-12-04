<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Http\Requests\StoreSection;
use App\Section;
use App\User;
use App\SectionUser;

class SectionController extends Controller
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
     * Список отделов
     *
     * @return resource Вывод страницы со списком
     */
    public function index()
    {
        $sections = Section::orderBy('id', 'desc')
            ->paginate(config('app.per_page'));
        return view('section/index', ['sections' => $sections]);
    }

    /**
     * Добавление нового отдела
     *
     * @return resource Вывод страницы добавления отдела
     */
    public function create()
    {
        $users = User::all();
        return view('section/create', ['users' => $users]);
    }

    /**
     * Редактирование информации об отделе
     *
     * @param  int $id ID отдела
     * @return resource Вывод страницы редактирования
     */
    public function edit($id)
    {
        $section = Section::findOrFail($id);
        $section_users = SectionUser::where('section_id', $id)
            ->pluck('user_id')
            ->toArray();
        $users = User::all();
        return view('section/edit', ['section' => $section, 'users' => $users, 'section_users' => $section_users]);
    }

    /**
     * Обновление информации об отделе
     *
     * @param  array  $request Пользовательские данные, прошедшие StoreSection
     * @param  int $id  ID отдела
     * @return resource Редирект на список отделов
     */
    public function update(StoreSection $request, $id)
    {
        //Поступивший запрос прошел валидацию
        // Получаем данные
        $validated = $request->validated();

        // Проверяем наличие изображения
        if (request()->fileToUpload) {
            // Генерируем имя файла
            $fileName = "img" . time() . '.' . request()->fileToUpload->getClientOriginalExtension();
            // Сохраняем картинку в папку logo
            $request->fileToUpload->storeAs('logo', $fileName);
        }

        // Обновляем данные отдела
    	$section = Section::findOrFail($id);
        $section->name = $validated['name'];
        $section->description = $validated['description'];

        if (isset($fileName)) {
            $section->logo = $fileName;
        }

	    $section->save();

        // Пользователи отдела в БД
        $section_users = SectionUser::where('section_id', $id)
            ->pluck('user_id')
            ->toArray();

        // Если пришел массив пользователей
        if (isset($validated['users'])) {
            // Массив ID пользователей для вставки
            $to_insert = array_diff($validated['users'], $section_users);
            // Массив ID пользователей для удаления
            $to_delete = array_diff($section_users, $validated['users']);

            // Удаляем устаревшие записи
            if ( ! empty($to_delete)) {
                SectionUser::whereIn('user_id', $to_delete)->delete();
            }

            // Добавляем новые записи
            if ( ! empty($to_insert)) {
                // Составляем массив для вставки
                $insert = [];
                foreach ($to_insert as $key => $value) {
                    $row = ['section_id' => $id, 'user_id' => $value];
                    $insert = array_merge($insert, [$row]);
                }
                SectionUser::insert($insert);
            }
        } elseif ( ! empty($section_users)) {
            // Пользователей не отметили
            // Удаляем все записи для отдела
            SectionUser::where('section_id', $id)->delete();
        }

        return Redirect::to("/sections")->withSuccess(__('Success updated'));
    }

    /**
     * Сохранение нового отдела
     *
     * @param array $request Пользовательские данные, прошедшие StoreSection
     * @return resource Редирект на список отделов
     */
    public function store(StoreSection $request)
    {
        //Поступивший запрос прошел валидацию
        // Получаем данные
        $validated = $request->validated();

        // Проверяем наличие изображения
        if (request()->fileToUpload) {
            // Генерируем имя файла
            $fileName = "img" . time() . '.' . request()->fileToUpload->getClientOriginalExtension();
            // Сохраняем картинку в папку logo
            $request->fileToUpload->storeAs('logo', $fileName);
        }

        // Сохраняем отдел
    	$section = new Section;
        $section->name = $validated['name'];
        $section->description = $validated['description'];
        $section->logo = (isset($fileName)) ? $fileName : '';
	    $section->save();

        // Если пришел массив пользователей
        if (isset($validated['users'])) {
                // Составляем массив для вставки
                $insert = [];
                foreach ($validated['users'] as $key => $value) {
                    $row = ['section_id' => $section->id, 'user_id' => $value];
                    $insert = array_merge($insert, [$row]);
                }
                SectionUser::insert($insert);
        }

        return Redirect::to("/sections")->withSuccess(__('Success created'));
    }

    /**
     * Удаление отдела
     *
     * @param  int $id ID отдела
     * @return string JSON Сообщение об успешном удалении
     */
    public function destroy($id)
    {
        Section::destroy($id);
	    return response()->json(__('Successfully deleted'));
    }
}
