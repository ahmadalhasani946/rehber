@extends('layouts.app')
@section('title','Edit A Friend ' . $friend->name)

@section('subject','Edit A Friend')

@section('content')
    <div class="container" style="max-width:500px;">
        <form method="post" action="{{route('friends.update', ['friend' => $friend->id])}}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="form-group">
                <label class="form-label @error('name') error @enderror" for="name">The Name </label>
                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="Enter The Name Of The Friend" value="{{ old('name', $friend->name) }}">
            </div>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label class="form-label @error('telephone') error @enderror" for="telephone">The Telephone </label>
                <input type="text" class="form-control @error('telephone') error @enderror" maxlength="11"  id="telephone" name="telephone" placeholder="0xxxxxxxxxx" value="{{ old('telephone', $friend->telephone) }}">
            </div>
            @error('telephone')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group" style="text-align:center;">
                <button class="btn btn-success" type="submit">Edit The Friend</button>
                <a class="btn btn-danger " href='{{ route('friends.index') }}' style="text-align:center;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

