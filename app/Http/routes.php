<?php

Route::get('/obtain', function () {
    $handle = fopen(base_path('stache.lock'), 'c');
    flock($handle, LOCK_EX);

    // If this is called before the other request does the check, it will appear unlocked.
    // Uncomment this to mimick the suggested stache locking code.
    // fclose($handle);

    sleep(5); // Visit /check while this is sleeping.

    return 'got it.';
});

Route::get('/check', function () {
    $handle = fopen(base_path('stache.lock'), 'c');
    $locked = !flock($handle, LOCK_EX | LOCK_NB);
    fclose($handle);

    return $locked
        ? 'The /obtain request has the lock.'
        : 'The /obtain request does *not* have the lock.';
});
