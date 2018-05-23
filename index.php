<?php

/**
 * index.php написан за пределами задания в процедурном стиле, чисто для тестирования реализации по заданию.
 * кодревью этого файла не делаю.
 */


require_once 'Model/Coworker.php';
require_once 'Model/Aspirant.php';
require_once 'Model/Position.php';

function beginBlock($text)
{
    $fs = '<br> ************************************************ <br>*<br>*';
    $ss = '<br>* Начало блока...<br>';
    echo $fs . $text . $ss;
    return;
}

function endBlock()
{
    echo '<br>*<br>* ...Конец блока' . '<br>************************************************<br>';
    return;
}

$isData = false;

// Проверяем текущее состояние БД

beginBlock('Проверяем первоначальное состояние должностей');
$persons = Position::getAll();

foreach ($persons as $person){
    echo '<br>';
    var_dump($person);
    $isData = true;
}
endBlock();


beginBlock('Проверяем первоначальное состояние сотрудников');
$persons = Coworker::getAll();

foreach ($persons as $person){
    echo '<br>';
    var_dump($person);
    $isData = true;
}
endBlock();


// Проверяем текущее состояние БД
beginBlock('Проверяем первоначальное состояние соискателей');
$persons = Aspirant::getAll();

foreach ($persons as $person){
    echo '<br>';
    var_dump($person);
    $isData = true;
}
endBlock();
/***************************************/


// Очистка таблиц
if ($isData){
    beginBlock('Были обнаружены старые данные. Удаляем.');
    Specialist::deleteAll();
    Position::deleteAll();
    endBlock();
}
/***************************************/

// Добавляем должности
beginBlock('Добавляем должности');
$positions = [];

$position = new Position();
$position->setId(1);
$position->setTitle('Джуниор');
$positions[] = $position;

$position = new Position();
$position->setId(2);
$position->setTitle('Мидл');
$positions[] = $position;

$position = new Position();
$position->setId(3);
$position->setTitle('Сеньор');
$positions[] = $position;

foreach ($positions as $position){
    echo '<br>';
    var_dump($position);
    $position->create();
}
endBlock();


// Добавляем соиcкателей
beginBlock('Добавляем соискателей:');
$aspirants = [];

$aspirant = new Aspirant();
$aspirant->setName('Иванов');
$aspirant->setResume('Умею всё');
$aspirant->setResumeDate('2017-03-01');
$aspirants[] = $aspirant;

$aspirant = new Aspirant();
$aspirant->setName('Петров');
$aspirant->setResume('Умею много чего');
$aspirant->setResumeDate('2017-03-01');
$aspirants[] = $aspirant;

$aspirant = new Aspirant();
$aspirant->setName('Бубликов');
$aspirant->setResume('Ничего не умею');
$aspirant->setResumeDate('2017-03-01');
$aspirants[] = $aspirant;

foreach ($aspirants as $aspirant){
    echo '<br>';
    var_dump($aspirant);
    $aspirant->create();
}
endBlock();
/***************************************/


// Проверяем текущее состояние БД
beginBlock('Проверяем текущее состояние соискателей');
$persons = Aspirant::getAll();

foreach ($persons as $person){
    echo '<br>';
    var_dump($person);
    echo '<br>';
}
endBlock();


//Принимаем на работу Бубликова
beginBlock('Принимаем на работу Бубликова');
$name = 'Бубликов';

if ($person = Specialist::findName($name)){
    $person = Aspirant::find($person->getId());
    $person->recruit('2018-05-26', 1);
} else {
    die('Не удалось найти ' . $name);
}
endBlock();
/***************************************/

// Проверяем текущее состояние базы
beginBlock('Проверяем текущее состояние сотрудников');
$persons = Coworker::getAll();

foreach ($persons as $person){
    echo '<br>';
    var_dump($person);
    $isData = true;
}
endBlock();


beginBlock('Проверяем текущее состояние соискателей');
$persons = Aspirant::getAll();

foreach ($persons as $person){
    echo '<br>';
    var_dump($person);
    $isData = true;
}
endBlock();
/***************************************/
