<?php

$time = time();

return [
    '10' => [
        'id' => 10,
        'title' => 'Book One',
        'year' => 2001,
        'description' => 'First book',
        'isbn' => 'ISBN-ONE',
        'photo' => 'photo1.jpg',
        'created_at' => $time,
        'updated_at' => $time,
    ],
    '11' => [
        'id' => 11,
        'title' => 'Book Two',
        'year' => 2002,
        'description' => 'Second book',
        'isbn' => 'ISBN-TWO',
        'photo' => 'photo2.jpg',
        'created_at' => $time,
        'updated_at' => $time,
    ],
];
