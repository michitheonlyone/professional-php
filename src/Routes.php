<?php declare(strict_types=1);

return [
    // Home
    [
        'GET',
        '/',
        'Socialnews\Frontpage\Presentation\FrontPageController#show'
    ],
    // Submission
    [
        'GET',
        '/submit',
        'Socialnews\Submission\Presentation\SubmissionController#show'
    ],
    [
        'POST',
        '/submit',
        'Socialnews\Submission\Presentation\SubmissionController#submit'
    ],
    // Register
    [
        'GET',
        '/register',
        'Socialnews\User\Presentation\RegistrationController#show'
    ],
    [
        'POST',
        '/register',
        'Socialnews\User\Presentation\RegistrationController#register'
    ],
    // Login
    [
        'GET',
        '/login',
        'Socialnews\User\Presentation\LoginController#show'
    ],
    [
        'POST',
        '/login',
        'Socialnews\User\Presentation\LoginController#login'
    ]
];