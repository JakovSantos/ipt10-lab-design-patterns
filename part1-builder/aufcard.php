<?php

declare(strict_types=1);

require_once __DIR__ . '/src/CallingCard.php';
require_once __DIR__ . '/src/CallingCardBuilder.php';
require_once __DIR__ . '/src/AufCallingCardBuilder.php';
require_once __DIR__ . '/src/CallingCardDirector.php';

// ---------------------------------------------
// Student data
// ---------------------------------------------

$firstName = "Juan";
$lastName = "Dela Cruz";

$data = [
    'businessName' => 'College of Computing Studies',
    'firstName'    => $firstName,
    'lastName'     => $lastName,
    'position'     => 'BSIT Student',
    'email'        => strtolower("{$lastName}.{$firstName}@auf.edu.ph"),
    'phone'        => sprintf('+1 (555) %03d-%04d', rand(100, 999), rand(1000, 9999)),
    'address'      => 'AUF CCS Building, Angeles City',
    'website'      => 'www.auf.edu.ph',
];

// ---------------------------------------------
// Build the card
// ---------------------------------------------

$builder = new AufCallingCardBuilder();
$director = new CallingCardDirector();

$card = $director->buildStandardCard($builder, $data);

// ---------------------------------------------
// Save it
// ---------------------------------------------

$outputDirectory = __DIR__ . '/cards';

try {
    $filename = $card->save($outputDirectory);
    echo "Calling card generated successfully.\n";
    echo "File: $filename\n";
} catch (\RuntimeException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
