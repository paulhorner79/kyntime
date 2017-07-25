# Timecode Syncing App

This syncs a central timecode to distributed browsers.

Login and go to `/timecode` to set/clear the timecode.  Go to the home page
to see the timecode display.

You can also assign events to various sections and view these through the
front end app.  This is really useful for running a large event based on a
timecode - you can assign cues based on times and set those against places
where people need to be to handle those cues.  It was developed for precisely
this purpose.

Seeding the database will set some dummy data and a dummy admin user.  Please
change the admin user's password (or better still add a new one and delete the
seeded admin user).

## Code

It uses Laravel for the back end, and VueJS for the front end.

A version of this is running at https://www.kyntime.com.

## Codestyle

PHP should be PSR-2 compliant (check by running `phpcs *`)

Javascript should pass the linting check as defined in `.eslintrc`.  This can

be checked by running
```bash
./node_modules/.bin/eslint resources/assets/js/*/**.*
```

## Tests

This uses Dusk/PHP unit for testing.

```bash
phpunit
php artisan dusk
```
