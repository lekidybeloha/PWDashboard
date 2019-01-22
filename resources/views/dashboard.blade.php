@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>{{ $dashboard->name }}</h1>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Créer une carte</button>
            </div>
            <div class="col-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">TO DO</li>
                    </ol>
                </nav>
                @if(count($toDo))
                    @foreach($toDo as $one)
                        <div class="card">
                            <div class="card-body">
                                {{ $one->name }}
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

            <div class="col-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">DOING</li>
                    </ol>
                </nav>
                @if(count($doing))
                    @foreach($doing as $one)
                        <div class="card">
                            <div class="card-body">
                                {{ $one->name }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="col-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">DONE</li>
                    </ol>
                </nav>
                @if(count($done))
                    @foreach($done as $one)
                        <div class="card">
                            <div class="card-body">
                                {{ $one->name }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="col-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">ARCHIVES</li>
                    </ol>
                </nav>
                @if(count($archives))
                    @foreach($archives as $one)
                        <div class="card">
                            <div class="card-body">
                                {{ $one->name }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer un carte</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('addCard') }}">
                    <label>Nom de la carte</label>
                    <input type="text" name="name" class="form-control" required>
                    <label>Statut</label>
                    <select name="status" class="form-control">
                        <option value="1">TO DO</option>
                        <option value="2">DOING</option>
                        <option value="3">DONE</option>
                        <option value="4">ARCHIVES</option>
                    </select>
                    <input type="hidden" name="dashboard" value="{{ $dashboard->id }}">
                    <input type="submit" class="btn btn-primary form-control create-tab" value="Créer la carte">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>

    </div>
</div>

@extends('layouts.footer')