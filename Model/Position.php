<?php
class Position
{

    private $id;
    private $title;

    /**
     * Список всех должностей
     * @return array
     */
    static public function getAll()
    {
        $sql = "SELECT id, title FROM position";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на получение списка должностей!');
        }

        if (!$st->execute()) {
            var_dump($sql);
            die('Не удалось выполнить запрос на получение списка должностей!');
        }

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Удаляет все должности
     */
    static function deleteAll()
    {
        $sql = "DELETE FROM position";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на кудаление всех должностей!');
        }


        if (!$st->execute()) {
            die('Не удалось выполнить запрос на кудаление всех должностей!');
        }

    }


    /**
     * Создает должность. ID - неавтоинкремент, следует задавать вручную
     */
    public function create()
    {
        $sql = "INSERT INTO position (id, title) VALUES (:id, :title)";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на добавление должности!');
        }

        $st->bindParam(':id', $this->getId(), PDO::PARAM_INT);
        $st->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);

        if (!$st->execute()) {
            echo '<br>';
            var_dump($this->getId(), $this->getTitle());
            echo '<br>';
            var_dump($sql);

            die('Не удалось выполнить запрос на добавление должности!');
        }

    }


    public function setId(string $value)
    {
        $this->id = $value;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setTitle(string $value)
    {
        $this->title = $value;
    }


    public function getTitle()
    {
        return $this->title;
    }


}

