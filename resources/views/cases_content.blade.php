@extends('main')
@section('banner')
<header class="hero-banner">
    <div class="container text-center">
        <div class="hero-content">
            <h1 class="display-4">Welcome to CaseRush</h1>
            <p class="lead">Open cases, win prizes, feel the rush.</p>
            <a href="#cases" class="btn btn-primary btn-lg mt-3">Start Opening</a>
        </div>
    </div>
</header>
@endsection
@section('content')
    <div class="container case-section" id="content">
        @foreach($section as $sect)
        <div class="col-md-12 d-flex justify-content-center">
            <button class="plus-button moderator-button hidden" name="edit_button" id="edit_button" onclick="changeSectionName({{ $sect->id_sections }})">
                <i class="fas fa-edit"></i>
            </button>
            <form action="{{ route('moderating.delete.section', $sect->id_sections) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="plus-button moderator-button hidden">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            <form id = 'move'action="{{ route('moderating.move.up.section', $sect->id_sections) }}" method="POST" style="display:inline;">
                @csrf
                <button class="plus-button moderator-button hidden">
                    <i class="fas fa-arrow-up"></i>
                </button>
            </form>

            <form action="{{ route('moderating.move.down.section', $sect->id_sections) }}" method="POST" style="display:inline;">
                @csrf
                <button class="plus-button moderator-button hidden">
                    <i class="fas fa-arrow-down"></i>
                </button>
            </form>
        </div>

        <form action="{{ route('moderating.change.section.name') }}" method="post" class="hidden" id="change_section_name_form_{{ $sect->id_sections }}">
            @csrf
            <input type="hidden" name="case_id" value="{{ $sect->id_sections }}">
            <div class="form-group">
                <label for="section_name_input_{{ $sect->id_sections }}">Nowa nazwa sekcji</label>
                <input type="text" name="section_name" id="section_name_input_{{ $sect->id_sections }}" class="form-control p_input" value="{{ $sect->section_name }}">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Zmienić</button>
                </div>
            </div>
        </form>

        <h2 id="section_name_{{ $sect->id_sections }}">{{ $sect->section_name }}</h2>
            <div class="row">
                <!-- Cases -->
                @foreach($cases as $case)
                    @if($case->sections_id_sections == $sect->id_sections)

                        <div class="col-md-3">
                        <div class="card case-card">
                            <img src="storage/images/cases/{{$case->image_url}}" alt="Case Image">
                            <div class="card-body">
                                <h5 class="card-title">{{$case->name}}</h5>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{$case->price}}</h5>
                            </div>
                            <div class="row">
                            <div class="col-md-3">
                                <form action="{{ route('moderating.delete.case', $case->id_case) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="plus-button moderator-button hidden">
                                    <i class="fas fa-trash"></i>
                                </button>
                                </form>
                            </div>
                                <div class="col-md-3">
                                    <form action="{{ route('case.updating.enter', $case->id_case) }}" method="POST" style="display:inline;">
                                        @csrf

                                        <button type="submit" class="plus-button moderator-button hidden">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                <div class="col-md-3 align-self-center">
                    <form action="{{ route('case.creating') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_section" value="{{ $sect->id_sections }}">
                        <button class="plus-button moderator-button hidden" id="add_button">+</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <span class="mdi mdi-showAddButtonat-line-spacing"></span>
    <div class="col-md-12 d-flex justify-content-center">
        <button class="plus-button moderator-button hidden" id="add_button"  onclick="showCreateSection()">+</button>
    </div>
    <form action="{{ route('moderating.add.section') }}" method="post" class="hidden" id="add_section_form">
        @csrf
        <div class="form-group" >
            <label>Nazwa sekcji</label>
            <input type="text" name="section_name" id = "section_name" class="form-control p_input" value="{{ old('username') }}">
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block enter-btn">Utworzyć</button>
            </div>
        </div>
    </form>


@endsection
