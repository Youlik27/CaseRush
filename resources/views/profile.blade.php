@extends('main')

@section('content')
    <div class="col-12 grid-margin" bis_skin_checked="1">
        <div class="card" bis_skin_checked="1">
            <div class="card-body" bis_skin_checked="1">
                <h4 class="card-title">Edytuj profil</h4>
                <form method="post" class="form-sample" id="profileForm"  enctype="multipart/form-data" action="{{ route('profile.edit') }}">
                    @csrf
                    <p class="card-description"> Informacje profilowe </p>
                    <div class="row" bis_skin_checked="1">
                        <!-- Left column for user information -->
                        <div class="col-md-6" bis_skin_checked="1">
                            <div class="form-group row" bis_skin_checked="1">
                                <label class="col-sm-3 col-form-label">Nazwa użytkownika</label>
                                <div class="col-sm-9" bis_skin_checked="1">
                                    <input type="text" class="form-control" name = 'username' id = 'username' placeholder="Username" value="{{Auth::user()->username}}" disabled>
                                </div>
                            </div>
                            <div class="form-group row" bis_skin_checked="1">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9" bis_skin_checked="1">
                                    <input type="email" class="form-control" name = 'email'  id = 'email' placeholder="Email" value="{{Auth::user()->email}}" disabled>
                                </div>
                            </div>
                            <div class="form-group row" bis_skin_checked="1">
                                <label class="col-sm-3 col-form-label">Steam ID</label>
                                <div class="col-sm-9" bis_skin_checked="1">
                                    <input type="text" class="form-control" name = 'steam_id' id = 'steam_id' placeholder="Steam ID" value="{{Auth::user()->steam_id?? ''}}" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Right column for avatar -->
                        <div class="col-md-6" bis_skin_checked="1">
                            <div class="form-group row" bis_skin_checked="1">
                                <label class="col-sm-3 col-form-label">Current Avatar</label>
                                <div class="col-sm-9" bis_skin_checked="1">
                                    <img src="{{ Auth::user()->image_url ?? 'storage/images/users_avatars/default.jpg' }}" alt="Current Avatar" class="img-fluid" style="max-width: 200px; max-height: 200px">
                                </div>
                            </div>
                            <div class="form-group row" bis_skin_checked="1">
                                <label class="col-sm-3 col-form-label">New Avatar</label>
                                <div class="col-sm-9" bis_skin_checked="1">
                                    <input type="file" name ='avatar' id = 'avatar' class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="border-left: 4px solid #dc3545; background-color: #fff0f1;">
                            <i class="mdi mdi-alert-circle-outline text-danger mr-3" style="font-size: 1.8rem;"></i>
                            <div>
                                <h6 class="font-weight-bold mb-2 text-danger">Oops! Coś poszło nie tak</h6>
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" class="mdi mdi-close text-danger"></span>
                            </button>
                        </div>
                    @endif
                    <div class="row" bis_skin_checked="1">
                        <div class="col-md-12" bis_skin_checked="1">
                            <!-- Edit button to make fields editable -->
                            <button type="button" class="btn btn-warning" id="editButton">Edit</button>
                            <button type="submit" class="btn btn-primary" id="saveButton" disabled>Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
