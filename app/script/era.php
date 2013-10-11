<?php
require_once '../_config.php';

$dataService = new DataService('eras');
$eras = $dataService->service_get();

$res = json_decode($eras, 1);

print_r($res);

// update image file names
$data = array(
    '518fbb46e4b00260820c4270' => array(
        'id' => 1,
        'name' => 'Ancient Era',
        'img' => '01-ancient.jpg',
        'times' => 'c. 3000 BCE-500 CE'
     ),
    '518fbb63e4b00260820c4271' => array(
        'id' => 2,
        'name' => 'Medieval Era',
        'img' => '02-medieval.jpg',
        'times' => 'c. 500-1500'
    ),
    '518fbb70e4b00260820c4272' => array(
        'id' => 3,
        'name' => 'Renaissance Era',
        'img' => '03-renaissance.jpg',
        'times' => 'c. 1400-1500'
    ),
    '518fbb83e4b00260820c4273' => array(
        'id' => 4,
        'name' => 'Age of Discovery',
        'img' => '04-discovery.jpg',
        'times' => 'c. 1450-1650'
    ),
    '518fbb95e4b00260820c4274' => array(
        'id' => 5,
        'name' => 'Age of Enlightenment',
        'img' => '05-enlightenment.jpg',
        'times' => 'c. 1650-1800'
    ),
    '518fbbb1e4b00260820c4275' => array(
        'id' => 6,
        'name' => 'Industrial Revolution',
        'img' => '06-industrial.jpg',
        'times' => 'c. 1760-1900'
    ),
    '518fbbc1e4b00260820c4276' => array(
        'id' => 7,
        'name' => 'Machine Age',
        'img' => '07-machine.jpg',
        'times' => 'c.1900-2000'
    )
);

/*
 * Array
(
    [0] => Array
        (
            [_id] => Array
                (
                    [$oid] => 518fbb46e4b00260820c4270
                )

            [id] => 1
            [name] => Ancient Era
            [img] => 1ancient.png
            [times] => c. 3000 BCE-500 CE
        )

    [1] => Array
        (
            [_id] => Array
                (
                    [$oid] => 518fbb63e4b00260820c4271
                )

            [id] => 2
            [name] => Medieval Era
            [img] => 2Medieval.jpg
            [times] => c. 500-1500
        )

    [2] => Array
        (
            [_id] => Array
                (
                    [$oid] => 518fbb70e4b00260820c4272
                )

            [id] => 3
            [name] => Renaissance Era
            [img] => 3renaissmall.jpg
            [times] => c. 1400-1500
        )

    [3] => Array
        (
            [_id] => Array
                (
                    [$oid] => 518fbb83e4b00260820c4273
                )

            [id] => 4
            [name] => Age of Discovery
            [img] => 4Discovery.jpg
            [times] => c. 1450-1650
        )

    [4] => Array
        (
            [_id] => Array
                (
                    [$oid] => 518fbb95e4b00260820c4274
                )

            [id] => 5
            [name] => Age of Enlightenment
            [img] => 5Enlightenment.jpg
            [times] => c. 1650-1800
        )

    [5] => Array
        (
            [_id] => Array
                (
                    [$oid] => 518fbbb1e4b00260820c4275
                )

            [id] => 6
            [name] => Industrial Revolution
            [img] => 6Industrial.png
            [times] => c. 1760-1900
        )

    [6] => Array
        (
            [_id] => Array
                (
                    [$oid] => 518fbbc1e4b00260820c4276
                )

            [id] => 7
            [name] => Machine Age
            [img] => 7Machine.jpg
            [times] => c.1900-2000
        )

)

 */

foreach ($data as $oid => $d) {
    $dataService->service_update($oid, $d);
}

$eras = $dataService->service_get();

$res = json_decode($eras, 1);

print_r($res);
