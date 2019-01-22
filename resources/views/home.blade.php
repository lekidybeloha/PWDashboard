@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($dashboard))
                @foreach($dashboard as $one)
                    <a href="{{ route('dashboard', ['id'    =>  $one->id ]) }}">
                        <div class="card" style="width: 18rem;">
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
</div>
@endsection

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

@extends('layouts.footer')

