@extends('back.layout')

@section('title', 'Créer un Utilisateur')

@section('content')
<div class="bg-white py-2 card">
    <div class="card-header">
        Créer un Utilisateur
    </div>
    <div class="container card-body py-2">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required style="height: 50px;">
                    @if ($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required style="height: 50px;">
                    @if ($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" name="password" class="form-control" id="password" required style="height: 50px;">
                    @if ($errors->has('password'))
                        <div class="text-danger">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirmer le Mot de Passe</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required style="height: 50px;">
                    @if ($errors->has('password_confirmation'))
                        <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="role" class="form-label">Rôle</label>
                <select name="role" class="form-control" id="role" required>
                    <option value="user">Utilisateur</option>
                    <option value="admin">Admin</option>
                </select>
                @if ($errors->has('role'))
                    <div class="text-danger">{{ $errors->first('role') }}</div>
                @endif
            </div>

            <div class="d-flex justify-content-end mx-4 my-2">
                <button type="submit" class="btn btn-primary">Ajouter l'Utilisateur</button>
            </div>
        </form>
    </div>
</div>
@endsection
