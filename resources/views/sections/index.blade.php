@extends('layout/layout')

@section('title')
Sections
@stop

@section('content')
<h2>Sections</h2>
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Active?</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($sections as $section)
        <tr>
            <td>
                {{$section}}
            </td>
            <td>
                @if($section->active)
                    <i class="text-success fa fa-check"></i>
                @else
                    <i class="text-danger fa fa-times"></i>
                @endif
            </td>
            <td>
                <button class="btn btn-sm btn-primary edit-section"
                    data-id="{{$section->id}}" data-title="{{$section->name}}" data-active="{{$section->active}}"
                    data-url="{{Route('sections.update', [$section->id])}}">Edit</button>
                <button class="btn btn-sm btn-danger delete-section"
                    data-id="{{$section->id}}" data-title="{{$section->name}}"
                    data-url="{{Route('sections.destroy', [$section->id])}}">Delete</button>
                <a href="{{Route('sections.events.index', $section->id)}}" class="btn btn-sm btn-default">Events</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>

<button class="btn btn-sm btn-primary btn-add" type="button" data-toggle="modal" data-target="#addModal">Add Section</button>
<!-- add modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{Route('sections.store')}}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">Add Section</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Section</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- edit modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">Edit Section</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input type="checkbox" name="active" value="1"> Active?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Section</button>
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
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">Delete Section</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "<span class="section_name"></span>"?
                    This will also delete any events under this section.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Section</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
