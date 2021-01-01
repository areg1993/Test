<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Traits\DataTable;
use App\Models\Task;

class Tasks extends Controller
{
    use DataTable;

    public function index(Request $request)
    {
        $results = $this->setDatatable($request)
            ->genQuery(Task::select(['id', 'name', 'email', 'status', 'text', 'created_at', 'updated_at']));
        return $this->response($results)->json();

    }

    public function getTask(Request $request)
    {
        $errors = [];
        if (!Auth::isLogged()) {
            $errors['auth'] = 'you don\'t have permission to access';
            return $this->response([
                'errors' => $errors
            ], 403)->json();
        }

        $id = $request->get('id');
        if (!$id) {
            $errors['id'] = 'Id can\'t be null';
        } elseif (!is_numeric($id)) {
            $errors['id'] = 'Id is not number';
        }

        if ($errors) {
            return $this->response([
                'errors' => $errors
            ], 400)->json();
        }

        $task = Task::find($id, ['name', 'text']);
        if ($task) {
            return $this->response($task)->json();
        }
    }

    public function editTask(Request $request)
    {
        $errors = [];

        if (!Auth::isLogged()) {
            $errors['auth'] = 'you don\'t have permission to access';
            return $this->response([
                'errors' => $errors
            ], 403)->json();
        }

        $id = $request->post('id');
        if (!$id) {
            $errors['id'] = 'Id can\'t be null';
        } elseif (!is_numeric($id)) {
            $errors['id'] = 'Id is not number';
        }

        if (!$request->post('text')) {
            $errors['text'] = 'Text can\'t be blank';
        } elseif (strlen($request->post('text')) < 3) {
            $errors['text'] = 'Text is too short (minimum is 5 characters)';
        }

        if ($errors) {
            return $this->response([
                'errors' => $errors
            ], 400)->json();
        }

        $task = Task::find($id);
        if ($task) {
            $data = [];
            if ($task->text !== $request->post('text')) {
                $data['status'] = 2;
            }
            $data['text'] = $request->post('text');
            $task->update($data);
            return $this->response([
                'success' => true
            ])->json();
        }
    }

    public function create(Request $request)
    {
        $errors = [];
        if (!$request->post('name')) {
            $errors['name'] = 'Name can\'t be blank';
        } elseif (strlen($request->post('name')) < 3) {
            $errors['name'] = 'Name is too short (minimum is 3 characters)';
        }

        if (!$request->post('email')) {
            $errors['email'] = 'Email can\'t be blank';
        } elseif (!filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email is not a valid email';
        }

        if (!$request->post('text')) {
            $errors['text'] = 'Text can\'t be blank';
        } elseif (strlen($request->post('text')) < 3) {
            $errors['text'] = 'Text is too short (minimum is 5 characters)';
        }

        if ($errors) {
            return $this->response([
                'errors' => $errors
            ], 400)->json();
        }

        if (Task::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'text' => $request->post('text'),
        ])) {
            return $this->response([
                'success' => true
            ])->json();
        }

    }

}