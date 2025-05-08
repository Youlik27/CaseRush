@extends('main')

@section('content')
    <div class="col-12 grid-margin" >
        <div class="card" >
            <div class="card-body" >
                <h4 class="card-title">Edytuj case</h4>
                <form method="POST" enctype="multipart/form-data" action="{{ route('case.updating',$case->id_case)}}">
                    @csrf
                    <input type="hidden" name="id_case" value="{{ $case->id_case}}">
                    <p class="card-description">Informacje o case</p>
                    <div class="row">
                        <!-- Left column for user information -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nazwa</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nazwa" value="{{ $case->name ?? rand() }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Opis</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="description" id="description" placeholder="Opis" value="{{ $case->description ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Cena</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="price" id="price" placeholder="Cena" value="{{ $case->price ?? '0' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Right column for avatar -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Obecne zdjęcie</label>
                                <div class="col-sm-9">
                                    <img src="storage/images/cases/{{ $case->image_url ?? '' }}" alt="Obecne zdjęcie" class="img-fluid" style="max-width: 200px; max-height: 200px">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nowe zdjęcie</label>
                                <div class="col-sm-9">
                                    <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="saveButton">Zapisz</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="row g-2">
            @foreach($items as $caseItem)
                <div class="col-4 col-sm-3 col-md-2 col-lg-1">
                    <div class="card case-card square-card text-center">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center p-1 h-100">
                            <img class="img-fluid item-image-small mb-1"
                                 src="{{ asset('storage/images/items/' . $caseItem->item->image_url) }}"
                                 alt="{{ $caseItem->item->name }}">
                            <div class="text-center small">
                                <strong>{{ $caseItem->item->name }}</strong><br>
                                💰 {{ number_format($caseItem->item->price, 2) }} zł<br>
                                🎯 {{ $caseItem->drop_rate }}%<br>
                                <span class="item-rarity rarity-{{ strtolower($caseItem->item->rarity) }}">
                            {{ $caseItem->item->rarity }}
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>



        <div class="col-md-3 align-self-center">
            <button class="plus-button moderator-button" id="add_button" onclick="showAddItemForm()">+</button>
        </div>
        <!-- Wyskakujący div do dodawania przedmiotów -->
        <div class="card modal-overlay" id="addItemModal">
            <h5 class="mb-3">Dodaj przedmiot</h5>
            <form method="POST" enctype="multipart/form-data" action="{{ route('item.creating',$case->id_case) }}">

                @csrf
                <div class="form-group">
                    <label for="item_name">Nazwa</label>
                    <input type="text" class="form-control" name="name" id="item_name" required>
                </div>
                <div class="form-group">
                    <label for="drop_rate">Drop Rate (%)</label>
                    <input type="number" class="form-control" name="drop_rate" id="drop_rate" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="rarity">Rzadkość</label>
                    <select class="form-control" name="rarity" id="rarity" required>
                        <option value="" disabled selected>Wybierz rzadkość</option>
                        <option value="common">Common</option>
                        <option value="uncommon">Uncommon</option>
                        <option value="rare">Rare</option>
                        <option value="epic">Epic</option>
                        <option value="legendary">Legendary</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Cena</label>
                    <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="image_url">Zdjęcie</label>
                    <input type="file" class="form-control" name="image_url" id="image_url" accept="image/*" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Dodaj</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddItemForm()">Anuluj</button>
                </div>
            </form>
        </div>
    </div>

@endsection
