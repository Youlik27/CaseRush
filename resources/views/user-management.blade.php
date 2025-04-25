@extends('main')


@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Управление аккаунтами пользователей</h4>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary mb-4">Добавить нового пользователя</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Роль</th>
                                <th>Дата регистрации</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Пример данных пользователей -->
                            <tr>
                                <td>1</td>
                                <td>Иван Иванов</td>
                                <td>ivanov@mail.com</td>
                                <td>Администратор</td>
                                <td>2025-01-01</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Редактировать</button>
                                    <button class="btn btn-danger btn-sm">Удалить</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Петр Петров</td>
                                <td>petrov@mail.com</td>
                                <td>Пользователь</td>
                                <td>2025-02-15</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Редактировать</button>
                                    <button class="btn btn-danger btn-sm">Удалить</button>
                                </td>
                            </tr>
                            <!-- Добавьте больше пользователей по необходимости -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

