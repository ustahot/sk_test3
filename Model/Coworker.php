<?php

require_once 'Model/Specialist.php';
require_once 'Classes/Cfg.php';

class Coworker extends Specialist
{

    /**
     * Список всех соискателей
     * @return array
     */
    static public function getAll()
    {
        $sql = "SELECT id, name, resume, resume_date
                FROM specialist
                WHERE recruitment_date IS NOT NULL 
        ";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на получение списка сотрудников!');
        }

        if (!$st->execute()) {
            var_dump($sql);
            die('Не удалось выполнить запрос на получение списка сотрудников!');
        }

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }


}

