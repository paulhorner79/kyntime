@extends('layout/layout')

@section('title')
Users
@stop

@section('content')
<h2>Users</h2>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                {{$user->name}}
            </td>
            <td>
                {{$user->email}}
            </td>
            <td>
                <button class="btn btn-sm btn-danger delete-user"
                    data-id="{{$user->id}}" data-title="{{$user->name}}" data-url="{{Route('users.delete')}}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<button class="btn btn-sm btn-primary btn-add" type="button" data-toggle="modal" data-target="#addModal">Add User</button>
<!-- add modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{Route('users.add')}}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Add User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="DELETE">
                <input name="id" type="hidden" value="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">Delete User</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "<span class="user_name"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
