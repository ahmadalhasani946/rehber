@extends('layouts.app')

@section('title','Yeni Arkadaş')

@section('subject','Yeni Arkadaşı Ekle')

@section('content')
    <div class="container" style="max-width:500px;">
        <form method="post" action="{{route('friends.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label @error('name') error @enderror" for="name">Adı </label>
                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="Enter The Name Of The Friend" value="{{ old('name') }}">
            </div>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label class="form-label @error('telephone') error @enderror" for="telephone">Telefon Numarası </label>
                <input type="text" class="form-control @error('telephone') error @enderror" id="telephone" name="telephone" maxlength="11" placeholder="0xxxxxxxxxx" value="{{ old('telephone') }}">
            </div>
            @error('telephone')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group" style="text-align:center;">
                <button class="btn btn-success" type="submit">Yeni Arkadaşı Ekle</button>
                <a class="btn btn-danger " href='{{ route('friends.index') }}' style="text-align:center;">
                    İptal Et
                </a>
            </div>
        </form>
    </div>
@endsection

