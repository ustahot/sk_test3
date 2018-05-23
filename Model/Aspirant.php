<?php

/**
 * Модель Соискатели
 * Каждый геттер и сеттер не коментирую. Это обычные геттеры и сеттеры на свойства
 *
 */

require_once 'Classes/MyDate.php';

class Aspirant extends Specialist
{

    public function setResume(string $value)
    {
        $this->resume = $value;
    }


    public function setResumeDate(string $value)
    {
        $format = 'Y-m-d';
        MyDate::checkOrDie($format, $value);

        $this->resumeDate = $value;
    }


    public function setRecruitmentDate(string $value)
    {
        $format = 'Y-m-d';
        MyDate::checkOrDie($format, $value);

        $this->recruitmentDate = $value;
    }


    /**
     * Найм соискателя
     * @param string $date Дата найма
     * @param int|null $positionId ID позиции в соответствии с моделью position
     */
    public function recruit(string $date, int $positionId = null)
    {
        $this->setRecruitmentDate($date);
        $this->setPositionId($positionId);
        $this->save();
    }


    /**
     * Список всех соискателей
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT id, name, resume, resume_date
                FROM specialist
                WHERE recruitment_date IS NULL 
        ";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на получение списка соискателей!');
        }

        if (!$st->execute()) {
            die('Не удалось выполнить запрос на получение списка соискателей!');
        }

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Создает соискателя в БД
     */
    public function create()
    {
        $sql = "INSERT INTO specialist (name, resume, resume_date) VALUES (:name, :resume, :resume_date)";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на добавление соискателя!');
        }

        $st->bindParam(':name', $this->getName(), PDO::PARAM_STR);
        $st->bindParam(':resume', $this->getResume(), PDO::PARAM_STR);
        $st->bindParam(':resume_date', $this->getResumeDate(), PDO::PARAM_STR);


        if (!$st->execute()) {
            echo '<br>';
            var_dump($this->getName(), $this->getResume(), $this->getResumeDate());
            echo '<br>';
            var_dump($sql);

            die('Не удалось выполнить запрос на добавление соискателя!');
        }

    }

    /**
     * Возвращает существующего соискателя по его ID
     * @param int $id
     * @return Aspirant
     */
    static public function find(int $id)
    {
        $sql = "SELECT id, name, resume, resume_date, recruitment_date, position_id
                FROM specialist
                WHERE id = :id 
        ";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на поиск специалисьа по имени!');
        }

        $st->bindParam(':id', $id, PDO::PARAM_STR);

        if (!$st->execute()) {
            die('Не удалось выполнить запрос на поиск специалисьа по имени!');
        }

        if (!$result = $st->fetch(PDO::FETCH_ASSOC)){
            die('Не найден соискатель с id ' . $id);
        }

        $specialist = new self();
        $specialist->setId($result['id']);
        $specialist->setName($result['name']);
        $specialist->setResume($result['resume']);

        if ($result['resume_date']){
            $specialist->setResumeDate($result['resume_date']);
        }

        if ($result['recruitment_date']){
            $specialist->setRecruitmentDate($result['recruitment_date']);
        }


        return $specialist;

    }

}

