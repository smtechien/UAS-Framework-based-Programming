@extends('layouts.global')
@section('title')
    User list
@endsection
@section('content')
    <form action="{{ route('users.index') }}">
        <div class="row">
            <div class="col-md-6">
                <input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control" placeholder="Masukkan email untuk filter...">
            </div>
            <div class="col-md-6">
                <input type="radio" name="status" id="active" class="form-control" value="ACTIVE" {{Request::get('status') == 'ACTIVE' ? 'checked' : '' }}>
                <label for="active">Active</label>
                <input type="radio" name="status" id="inactive" class="form-control" value="INACTIVE" {{Request::get('status') == 'INACTIVE' ? 'checked' : '' }}>
                <label for="inactive">Inactive</label>
                <input type="submit" value="Filter" class="btn btn-primary">
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
        </div>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><b>Name</b></th>
                <th><b>Username</b></th>
                <th><b>Email</b></th>
                <th><b>Avatar</b></th>
                <th><b>Status</b></th>
                <th><b>Action</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->avatar)
                            <img src="{{asset('storage/'.$user->avatar)}}" width="70px" alt="gambar {{ $user->name }}">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if ($user->status == "ACTIVE")
                            <span class="badge badge-success">
                                {{ $user->status }}
                            </span>
                        @else
                            <span class="badge badge-danger">
                                {{ $user->status }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-info text-white btn-sm" href="{{ route('users.edit', [$user->id]) }}">Edit</a>
                        <a href="{{ route('users.show', [$user->id]) }}" class="btn btn-primary btn-sm">Detail</a>
                        <form action="{{ route('users.destroy', [$user->id]) }}" class="d-inline" onsubmit="return confirm('Delete this user permanently ?')" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                        </form>
                    </td>
                </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{ $users->appends(Request::all())->links() }}
                    </td>
                </tr>
            </tfoot>
        </tbody>
    </table>
@endsection