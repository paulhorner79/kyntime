# Timecode Syncing App

This syncs a central timecode to distributed browsers.

Login and go to `/timecode` to set/clear the timecode.  Go to the home page
to see the timecode display.

You can also assign events to various sections and view these through the
front end app.

It uses Laravel for the back end, and VueJS for the front end.

A version of this is available at https://www.kyntime.com.

## Codestyle

PHP should be PSR-2 compliant (check by running `phpcs *`)

Javascript should pass the linting check as defined in `.eslintrc`.  This can

be checked by running
```bash
./node_modules/.bin/eslint resources/assets/js/*/**.*
```

## Tests

This uses Dusk for testing.

```bash
php artisan dusk
```
