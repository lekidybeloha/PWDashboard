@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>{{ $dashboard->name }}</h1>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createList">Créer une liste</button>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createCard" @if(!count($lists)) disabled @endif>Créer une carte</button>
            </div>

            @if(count($lists))
                @foreach($lists as $one)
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $one->title }}</h5>

                            </div>
                        </div>
                        <div>
                            @foreach($tasks as $t)
                                @if($t->id_cart == $one->id)
                                    <button type="button" class="btn btn-secondary form-control tasks" data-id="{{ $t->id }}" data-name="{{ $t->name }}">{{ $t->name }}</button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            <!--MODAL SECTION : CREATE LIST-->
            <div id="createList" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Créer une liste</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('addList') }}">
                                <label>Nom de la liste</label>
                                <input type="text" name="title" class="form-control" required>
                                <input type="hidden" name="id_dashboard" value="{{ $dashboard->id }}">
                                <input type="submit" class="btn btn-primary form-control create-tab" value="Créer la liste">
                                @csrf
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>

                </div>
            </div>

            <!--MODAL SECTION : CREATE CARD-->
            <div id="createCard" class="modal fade" role="dialog">
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
                                <label>Liste</label>
                                <select name="id_card" class="form-control">
                                    @if(count($lists))
                                        @foreach($lists as $l)
                                            <option value="{{ $l->id }}">{{ $l->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="id_dashboard" value="{{ $dashboard->id }}">
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

            <!--MODAL SECTION : CARD DETAILS-->
            <div id="cartDetails" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="task-title"></h4>
                        </div>
                        <div class="modal-body">
                            <label>Description</label>
                            <textarea id="descCart" class="form-control">Ajouter une description ici</textarea>
                            <input type="hidden" value="" id="id_task">
                            <button class="btn btn-success" id="saveDesc">Enregistrer</button>
                            <label>Checklist</label>
                            <div class="progress">
                                <div class="progress-bar" id="checkProgress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>

                </div>
            </div>
    </div>
@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="{{ asset('public/js/dashboard.js') }}" ></script>
    <script>
        var cartDetails     = "{{ route('cartDetails') }}";
        var saveCartDetails = "{{ route('saveCartDetails') }}";
    </script>
@endsection