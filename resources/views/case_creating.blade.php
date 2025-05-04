@extends('main')

@section('content')
    <div class="col-12 grid-margin" >
        <div class="card" >
            <div class="card-body" >
                <h4 class="card-title">Edytuj case</h4>
                <form method="post" class="form-sample" id="profileForm"  enctype="multipart/form-data" action="{{ route('case.updating') }}">
                    @csrf
                    <p class="card-description">  Informacje o case</p>
                    <div class="row" >
                        <!-- Left column for user information -->
                        <div class="col-md-6" >
                            <div class="form-group row" >
                                <label class="col-sm-3 col-form-label">Nazwa</label>
                                <div class="col-sm-9" >
                                    <input type="text" class="form-control" name = 'name' id = 'name' placeholder="Nazwa" value="{{$case->name ?? rand()}}}">
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label class="col-sm-3 col-form-label">Opis</label>
                                <div class="col-sm-9" >
                                    <input type="text" class="form-control" name = 'description'  id = 'description' placeholder="Opis" value="{{$case->description  ?? ''}}" >
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label class="col-sm-3 col-form-label">Cena</label>
                                <div class="col-sm-9" >
                                    <input type="number" class="form-control" name = 'price' id = 'price' placeholder="Cena" value="{{$case->price  ?? '0'}}">
                                </div>
                            </div>
                        </div>

                        <!-- Right column for avatar -->
                        <div class="col-md-6" >
                            <div class="form-group row" >
                                <label class="col-sm-3 col-form-label">Obecne zdjęcie</label>
                                <div class="col-sm-9" >
                                    <img src="{{ $case->image_url ?? '' }}" alt="Obecne zdjęcie" class="img-fluid" style="max-width: 200px; max-height: 200px">
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label class="col-sm-3 col-form-label">Nowe zdjęcie</label>
                                <div class="col-sm-9" >
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
                    <div class="row" >
                        <div class="col-md-12" >
                            <!-- Edit button to make fields editable -->
                            <button type="submit" class="btn btn-primary" id="saveButton" >Zapisz</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @foreach($items as $item)
            <div class="col-md-3 align-self-center">

            </div>
        @endforeach
        <div class="col-md-3 align-self-center">
            <form action="{{ route('case.creating') }}" method="POST">
                @csrf
                <button class="plus-button moderator-button" id="add_button">+</button>
            </form>
        </div>
    </div>

@endsection
