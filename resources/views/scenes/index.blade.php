@extends('layout/layout')

@section('title')
Scenes
@stop

@section('content')
<h2>Scenes</h2>
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Start</th>
            <th class="hidden-xs hidden-sm">End</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($scenes as $scene)
        <tr>
            <td>
                {{$scene}}
            </td>
            <td>
                @if ($scene->start)
                    {{$scene->start['readable']}}
                @endif
            </td>
            <td class="hidden-xs hidden-sm">
                @if ($scene->end)
                    {{$scene->end['readable']}}
                @endif
            </td>
            <td>
                <button class="btn btn-sm btn-primary edit-scene"
                    data-id="{{$scene->id}}" data-title="{{$scene->name}}" data-start="{{json_encode($scene->start)}}" data-end="{{json_encode($scene->end)}}"
                    data-url="{{Route('scenes.update', $scene->id)}}">Edit</button>
                <button class="btn btn-sm btn-danger delete-scene"
                    data-id="{{$scene->id}}" data-title="{{$scene->name}}" data-url="{{Route('scenes.destroy', $scene->id)}}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>

<button class="btn btn-sm btn-primary btn-add" type="button" data-toggle="modal" data-target="#addModal">Add Scene</button>

<!-- add modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{Route('scenes.store')}}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">Add Scene</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="start['hour']">Start</label>
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="start[hour]" placeholder="Hours" min="0" max="24" step="1">
                            </div>
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="start[minute]" placeholder="Minutes" min="0" max="59" step="1">
                            </div>
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="start[second]" placeholder="Seconds" min="0" max="59" step="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end['hour']">End</label>
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="end[hour]" placeholder="Hours" min="0" max="24" step="1">
                            </div>
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="end[minute]" placeholder="Minutes" min="0" max="59" step="1">
                            </div>
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="end[second]" placeholder="Seconds" min="0" max="59" step="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Scene</button>
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
                    <h4 class="modal-title">Edit Scene</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="#hour-start">Start</label>
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" name="start[hour]" id="hour-start" placeholder="Hours" min="0" max="24" step="1">
                            </div>
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" name="start[minute]" id="minute-start" placeholder="Minutes" min="0" max="59" step="1">
                            </div>
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" name="start[second]" id="second-start" placeholder="Seconds" min="0" max="59" step="1">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end['hour']">End</label>
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" name="end[hour]" id="hour-end" placeholder="Hours" min="0" max="24" step="1">
                            </div>
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" name="end[minute]" id="minute-end" placeholder="Minutes" min="0" max="59" step="1">
                            </div>
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" name="end[second]" id="second-end" placeholder="Seconds" min="0" max="59" step="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Scene</button>
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
                    <h4 class="modal-title">Delete Scene</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "<span class="scene_name"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Scene</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
