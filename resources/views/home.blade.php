@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 dashboard-list">
            @if(!empty($favorites))
                <h2>Tableaux favoris</h2>
                @foreach($favorites as $one)
                    <a href="{{ route('dashboard', ['id'    =>  $one->id ]) }}">
                        <div class="card" style="width: 18rem; @if($one->color != '') background-color: {{ $one->color }}!important; @endif">
                            <div class="card-body">
                                <h5 class="card-title">{{ $one->name }}</h5>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
            @if(count($dashboard_coop))
                @foreach($dashboard_coop as $one)
                    <a href="{{ route('dashboard', ['id'    =>  $one->id ]) }}">
                        <div class="card" style="width: 18rem; @if($one->color != '') background-color: {{ $one->color }}!important; @endif">
                            <div class="card-body">
                                <h5 class="card-title">{{ $one->name }}</h5>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
            <h2>Tableaux personnels</h2>
            @if(count($dashboard))
                @foreach($dashboard as $one)
                    <a href="{{ route('dashboard', ['id'    =>  $one->id ]) }}">
                        <div class="card" style="width: 18rem; @if($one->color != '') background-color: {{ $one->color }}!important; @endif">
                            <div class="card-body">
                                <h5 class="card-title">{{ $one->name }}</h5>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif

            @if(count($dashboard_coop))
                @foreach($dashboard_coop as $one)
                    <a href="{{ route('dashboard', ['id'    =>  $one->id ]) }}">
                        <div class="card" style="width: 18rem; @if($one->color != '') background-color: {{ $one->color }}!important; @endif">
                            <div class="card-body">
                                <h5 class="card-title">{{ $one->name }}</h5>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
                <br>
                <a href="#" data-toggle="modal" data-target="#myModal">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Créer un tableau</h5>
                    </div>
                </div>
                </a>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Créer un tableau</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('add') }}">
                        <label>Nom du tableau</label>
                        <input type="text" name="name" class="form-control" required>
                        <label>Type du tableau</label>
                        <select name="privacy" class="form-control">
                            <option value="0">Public</option>
                            <option value="1">Privée</option>
                        </select>
                        <label>Choisir une couleur</label>
                        <input type="color" name="color" value="#00aecc">
                        <span></span>
                        <input type="hidden" name="user" value="{{ $id_user }}">
                        <input type="submit" class="btn btn-primary form-control create-tab" value="Créer le tableau">
                        @csrf
                    </form>
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

@endsection

