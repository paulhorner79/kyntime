/* global require, $ */
/* eslint no-console: ["error", { allow: ["error"] }] */

require('./app');

// JQuery - admin app
$(function() {
    $('.edit-section').click(function () {
        var modal  = $('#editModal'),
            url    = $(this).attr('data-url'),
            title  = $(this).attr('data-title'),
            active = $(this).attr('data-active');

        modal.find('form').attr('action', url);
        modal.find('input[name=name]').val(title);
        if (active === 1) {
            modal.find('input[name=active]').prop('checked', true);
        }
        else {
            modal.find('input[name=active]').prop('checked', false);
        }
        modal.modal('show');
    });

    $('.delete-section').click(function () {
        var modal  = $('#deleteModal'),
            title  = $(this).attr('data-title'),
            url    = $(this).attr('data-url');

        modal.find('form').attr('action', url);
        $('.section_name').html(title);
        modal.modal('show');
    });

    $('.edit-event').click(function () {
        var modal  = $('#editModal'),
            url    = $(this).attr('data-url'),
            event  = JSON.parse($(this).attr('data-event')),
            active = event.active,
            notes  = event.notes,
            title  = event.name,
            code   = event.calculated;

        modal.find('form').attr('action', url);
        modal.find('input[name=name]').val(title);
        modal.find('.event-notes').val(notes);

        $('#hour-edit').val(code.hour);
        $('#minute-edit').val(code.minute);
        $('#second-edit').val(code.second);

        if (active === 1) {
            modal.find('input[name=active]').prop('checked', true);
        }
        else {
            modal.find('input[name=active]').prop('checked', false);
        }
        modal.modal('show');
    });

    $('.edit-scene').click(function () {
        var modal  = $('#editModal'),
            url    = $(this).attr('data-url'),
            title  = $(this).attr('data-title'),
            start  = JSON.parse($(this).attr('data-start')),
            end    = JSON.parse($(this).attr('data-end'));

        modal.find('form').attr('action', url);
        modal.find('input[name=name]').val(title);

        if (start) {
            $('#hour-start').val(start.time.hour);
            $('#minute-start').val(start.time.minute);
            $('#second-start').val(start.time.second);
        }

        if (end) {
            $('#hour-end').val(end.time.hour);
            $('#minute-end').val(end.time.minute);
            $('#second-end').val(end.time.second);
        }
        modal.modal('show');
    });

    $('.delete-event').click(function () {
        var modal  = $('#deleteModal'),
            title  = $(this).attr('data-title'),
            url    = $(this).attr('data-url');

        modal.find('form').attr('action', url);
        $('.event_name').html(title);
        modal.modal('show');
    });

    $('.delete-scene').click(function () {
        var modal  = $('#deleteModal'),
            title  = $(this).attr('data-title'),
            url    = $(this).attr('data-url');

        modal.find('form').attr('action', url);
        $('.scene_name').html(title);
        modal.modal('show');
    });

    $('.delete-user').click(function () {
        var modal  = $('#deleteModal'),
            id     = $(this).attr('data-id'),
            title  = $(this).attr('data-title'),
            url    = $(this).attr('data-url');

        modal.find('form').attr('action', url);
        modal.find('input[name=id]').val(id);
        $('.user_name').html(title);
        modal.modal('show');
    });
});
