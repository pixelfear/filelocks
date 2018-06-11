<?php

Route::get('/obtain', function () {
    $handle = fopen(base_path('stache.lock'), 'c');
    flock($handle, LOCK_EX);

    sleep(5); // Visit /check while this is sleeping.

    fclose($handle);

    return 'got it.';
});

Route::get('/check', function () {
    $handle = fopen(base_path('stache.lock'), 'c');
    $locked = !flock($handle, LOCK_EX | LOCK_NB);
    fclose($handle);

    return $locked ? 'locked' : 'unlocked';
});
