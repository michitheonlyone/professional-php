<?php declare(strict_types=1);

return [
    [
        'GET',
        '/',
        'Socialnews\Frontpage\Presentation\FrontPageController#show'
    ],
    [
        'GET',
        '/submit',
        'Socialnews\Submission\Presentation\SubmissionController#show'
    ]
];