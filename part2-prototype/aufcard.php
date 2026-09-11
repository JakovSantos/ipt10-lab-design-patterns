<?php

declare(strict_types=1);

require_once __DIR__ . '/src/CallingCardPrototype.php';

// ---------------------------------------------
// Students
// ---------------------------------------------

$students = [
    ['first_name' => 'Felicity', 'last_name' => 'Hampton'],
    ['first_name' => 'Hank', 'last_name' => 'Rice'],
    ['first_name' => 'Ada', 'last_name' => 'Wilson'],
    ['first_name' => 'Daniel', 'last_name' => 'Salgado'],
    ['first_name' => 'Avalynn', 'last_name' => 'Crane'],
    ['first_name' => 'Fox', 'last_name' => 'Summers'],
    ['first_name' => 'Frankie', 'last_name' => 'Andersen'],
    ['first_name' => 'Alistair', 'last_name' => 'Decker'],
    ['first_name' => 'Aleena', 'last_name' => 'Phillips'],
    ['first_name' => 'Andrew', 'last_name' => 'Marks'],
    ['first_name' => 'Monica', 'last_name' => 'French'],
    ['first_name' => 'Corey', 'last_name' => 'Hess'],
    ['first_name' => 'Kaliyah', 'last_name' => 'Richard'],
    ['first_name' => 'Ahmed', 'last_name' => 'Richardson'],
    ['first_name' => 'Allison', 'last_name' => 'Cortes'],
    ['first_name' => 'Banks', 'last_name' => 'McGee'],
    ['first_name' => 'Kayleigh', 'last_name' => 'Mendoza'],
    ['first_name' => 'Dominic', 'last_name' => 'Atkins'],
    ['first_name' => 'Mina', 'last_name' => 'Beasley'],
    ['first_name' => 'Stanley', 'last_name' => 'Jefferson'],
];

// ---------------------------------------------
// Build the master prototype once
// ---------------------------------------------

$prototype = new CallingCardPrototype(
    businessName: 'College of Computing Studies',
    position: 'BSIT Student',
    phone: sprintf('+1 (555) %03d-%04d', rand(100, 999), rand(1000, 9999)),
    address: 'AUF CCS Building, Angeles City',
    website: 'www.auf.edu.ph',
);

// ---------------------------------------------
// Clone the prototype for every student and save
// ---------------------------------------------

$outputDirectory = __DIR__ . '/cards';
$generated = 0;

foreach ($students as $student) {
    $card = clone $prototype;
    $card->renderStudent($student['first_name'], $student['last_name']);

    try {
        $filename = $card->save($outputDirectory);
        echo "Generated: {$student['first_name']} {$student['last_name']} -> $filename\n";
        $generated++;
    } catch (\RuntimeException $e) {
        echo "ERROR for {$student['first_name']} {$student['last_name']}: " . $e->getMessage() . "\n";
    }
}

echo "\nDone. $generated of " . count($students) . " calling cards generated.\n";
