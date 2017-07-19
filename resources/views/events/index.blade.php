@extends('layout/layout')

@section('title')
{{$section->name}}: Events
@stop

@section('content')
<h2>{{$section->name}}: Events</h2>
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Notes</th>
            <th>Timecode</th>
            <th>Active?</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($events as $event)
        <tr>
            <td>
                {{$event}}
            </td>
            <td>
                {{$event->notes}}
            </td>
            <td>
                {{$event->readable}}
            </td>
            <td>
                @if($event->active)
                    <i class="text-success fa fa-check"></i>
                @else
                    <i class="text-danger fa fa-times"></i>
                @endif
            </td>
            <td>
                <button class="btn btn-sm btn-primary edit-event"
                    data-event="{{json_encode($event)}}" data-url="{{Route('sections.events.update', [$section->id, $event->id])}}">Edit</button>
                <button class="btn btn-sm btn-danger delete-event"
                    data-id="{{$event->id}}" data-title="{{$event->name}}" data-url="{{Route('sections.events.destroy', [$section->id, $event->id])}}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<a class="btn btn-sm btn-default" href="{{Route('sections.index')}}">All sections</a>

<button class="btn btn-sm btn-primary btn-add" type="button" data-toggle="modal" data-target="#addModal">Add Event</button>
<!-- add modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{Route('sections.events.store', $section->id)}}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title">Add Event</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="timecode['hour']">Timecode</label>
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="timecode[hour]" placeholder="Hours" min="0" max="24" step="1">
                            </div>
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="timecode[minute]" placeholder="Minutes" min="0" max="59" step="1">
                            </div>
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="timecode[second]" placeholder="Seconds" min="0" max="59" step="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Event</button>
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
                    <h4 class="modal-title">Edit Event</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control event-notes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="#hour-edit">Timecode</label>
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="timecode[hour]" id="hour-edit" placeholder="Hours" min="0" max="24" step="1">
                            </div>
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="timecode[minute]" id="minute-edit" placeholder="Minutes" min="0" max="59" step="1">
                            </div>
                            <div class="col-xs-4">
                                <input type="tel" class="form-control" name="timecode[second]" id="second-edit" placeholder="Seconds" min="0" max="59" step="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input type="checkbox" name="active" value="1"> Active?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Event</button>
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
                    <h4 class="modal-title">Delete Event</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "<span class="event_name"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
