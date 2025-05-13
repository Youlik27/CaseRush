@extends('main')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Zarządzanie użytkownikami</h4>
                    </div>
                    <div class="row mb-3">
                        <form method="GET" action="{{ url()->current() }}" class="row mb-3">
                            <div class="col-md-8">
                                <input type="text" name="search" class="form-control" placeholder="Szukaj użytkowników..." value="{{ $search }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Szukaj</button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Użytkownik</th>
                                <th>Email</th>
                                <th>Rola</th>
                                <th>Saldo</th>
                                <th>Status</th>
                                <th>Data rejestracji</th>
                                <th>Akcje</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr data-userid="{{ $user->id_user }}">
                                    <td>{{ $user->id_user }}</td>
                                    <td class="username-cell">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->image_url ?? asset('storage/images/users_avatars/default.jpg') }}"
                                                 class="rounded-circle mr-2" width="40" height="40" alt="avatar">
                                            <div>
                                                <strong id="usernameText_{{$user->id_user}}" class="username-text">{{ $user->username }}</strong>
                                                <input id="usernameInput_{{$user->id_user}}" class="hidden" value="{{$user->username}}">
                                                @if($user->steam_id)
                                                    <div class="text-muted small steam-id">Steam ID: {{ $user->steam_id }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="email-cell">
                                        <strong id="emailText_{{$user->id_user}}">{{ $user->email }}</strong>
                                        <input id="emailInput_{{$user->id_user}}" class="hidden" value="{{ $user->email }}">
                                    </td>
                                    <td class="role-cell">
                                        @php
                                            $role = $user->roles->first()->name ?? 'user';
                                            $roleClass = [
                                                'admin' => 'badge-danger',
                                                'moderator' => 'badge-warning',
                                                'user' => 'badge-primary'
                                            ][$role];
                                        @endphp
                                        <span class="badge {{ $roleClass }}">
                                            {{ $role }}
                                        </span>
                                    </td>
                                    <td class="balance-cell">
                                        <strong id="saldoText_{{$user->id_user}}">{{ number_format($user->balance, 2) }} zł</strong>
                                        <input id="saldoInput_{{$user->id_user}}" class="hidden" value="{{ number_format($user->balance, 2) }}">
                                    </td>
                                    <td class="status-cell">
                                        <span class="badge badge-{{ $user->banned_at ? 'danger' : 'success' }}">
                                            {{ $user->banned_at ? 'Zablokowany' : 'Aktywny' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="change_{{$user->id_user}}" onclick="showChangeInput({{ $user->id_user }})" class="btn btn-outline-primary btn-sm edit-user moderator-button">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            <button onclick="saveUserData({{ $user->id_user }})" id="save_{{$user->id_user}}" class="btn btn-outline-success btn-sm save-user moderator-button hidden">
                                                <i class="mdi mdi-content-save"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Nie znaleziono użytkowników</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
                        <div class="d-flex justify-content-between mt-4">
                            <div class="text-muted">
                                @if($users->total() > 0)
                                    Wyświetlanie od {{ $users->firstItem() }} do {{ $users->lastItem() }} z {{ $users->total() }} użytkowników
                                @else
                                    Brak użytkowników do wyświetlenia
                                @endif
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
    <script>
        function showChangeInput(userId) {
            const usernameText = document.getElementById(`usernameText_${userId}`);
            const usernameInput = document.getElementById(`usernameInput_${userId}`);

            const emailText = document.getElementById(`emailText_${userId}`);
            const emailInput = document.getElementById(`emailInput_${userId}`);

            const saldoText = document.getElementById(`saldoText_${userId}`);
            const saldoInput = document.getElementById(`saldoInput_${userId}`);

            const buttons = document.querySelectorAll(`#change_${userId}, #save_${userId}`);

            usernameText.classList.toggle('hidden');
            usernameInput.classList.toggle('hidden');

            emailText.classList.toggle('hidden');
            emailInput.classList.toggle('hidden');

            saldoText.classList.toggle('hidden');
            saldoInput.classList.toggle('hidden');

            buttons.forEach(button => button.classList.toggle('hidden'));
        }
        function saveUserData(userId) {
            const username = document.getElementById(`usernameInput_${userId}`).value;
            const email = document.getElementById(`emailInput_${userId}`).value;
            const saldo = document.getElementById(`saldoInput_${userId}`).value;

            $.ajax({
                url: '{{ url('update-user') }}/' + userId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    username: username,
                    email: email,
                    balance: saldo
                },
                success: function(response) {
                    if (response.success) {
                        document.getElementById(`usernameText_${userId}`).innerText = username;
                        document.getElementById(`emailText_${userId}`).innerText = email;
                        document.getElementById(`saldoText_${userId}`).innerText = saldo;
                        showChangeInput(userId);
                    } else {
                        alert('Błąd podczas aktualizacji danych użytkownika');
                    }
                },
                error: function() {
                    alert('Błąd zapytania, spróbuj ponownie');
                }
            });
        }
    </script>




    <style>
        .badge-admin {
            background-color: #dc3545;
        }
        .badge-moderator {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-user {
            background-color: #007bff;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }
        .btn-group .btn {
            padding: 0.375rem 0.5rem;
        }
        .pagination {
            margin-bottom: 0;
        }
    </style>

