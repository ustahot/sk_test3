<?

class Specialist
{
    protected $id;
    protected $name;
    protected $resume;
    protected $resumeDate;
    protected $recruitmentDate;
    protected $positionId;


    /**
     * Реализован здесь, т.к. метод общий и для соискателей, и для сотрудников
     * @param string $value
     */
    public function setName(string $value)
    {
        $this->name = $value;
    }


    public function setId(string $value)
    {
        $this->id = $value;
    }


    /**
     * Реализован здесь, т.к. метод общий и для соискателей, и для сотрудников
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Реализован здесь, т.к. метод общий и для соискателей, и для сотрудников
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Реализован здесь, т.к. метод нужен для общего метода save()
     * @return mixed
     */
    public function getResume()
    {
        return $this->resume;
    }


    /**
     * Реализован здесь, т.к. метод нужен для общего метода save()
     * @return mixed
     */
    public function getRecruitmentDate()
    {
        return $this->recruitmentDate;
    }


    /**
     * Реализован здесь, т.к. метод нужен для общего метода save()
     * @return mixed
     */
    public function getResumeDate()
    {
        return $this->resumeDate;
    }


    /**
     * Реализован здесь, т.к. метод нужен для общего метода save()
     * @return mixed
     */
    public function getPositionId()
    {
        return $this->positionId;
    }


    /**
     * Реализован здесь, т.к. метод нужен для приема соискателя на работу и для возможной смены должности сотрудника
     * @param string $value
     */
    public function setPositionId(string $value)
    {
        $this->positionId = $value;
    }


    /**
     * Ищет специалиста по имени. Возвращает соответствующий объект с усеченным набором свойств
     * @param string $name
     * @return Specialist
     */
    static public function findName(string $name)
    {
        $sql = "SELECT id, name, resume, resume_date, recruitment_date, position_id
                FROM specialist
                WHERE name = :name 
        ";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на поиск специалисьа по имени!');
        }

        $st->bindParam(':name', $name, PDO::PARAM_STR);

        if (!$st->execute()) {
            die('Не удалось выполнить запрос на поиск специалисьа по имени!');
        }

        $result = $st->fetch(PDO::FETCH_ASSOC);

        $specialist = new self();
        $specialist->setId($result['id']);
        $specialist->setName($result['name']);

        return $specialist;

    }

    /**
     * Сохраняет изменения по специалисту
     */
    public function save()
    {
        $sql = "UPDATE specialist
                SET name = :name,
                    resume = :resume,
                    resume_date = :resume_date,
                    recruitment_date = :recruitment_date,
                    position_id = :position_id
                WHERE id = :id 
        ";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на обновление специалиста!');
        }


        $st->bindParam(':id', $this->getId(), PDO::PARAM_INT);
        $st->bindParam(':name', $this->getName(), PDO::PARAM_INT);
        $st->bindParam(':resume', $this->getResume(), PDO::PARAM_STR);
        $st->bindParam(':resume_date', $this->getResumeDate(), PDO::PARAM_STR);
        $st->bindParam(':recruitment_date', $this->getRecruitmentDate(), PDO::PARAM_STR);
        $st->bindParam(':position_id', $this->getPositionId(), PDO::PARAM_INT);


        if (!$st->execute()) {
            die('Не удалось выполнить запрос на обновление специалиста!');
        }

    }


    /**
     * Очищает таблицу. Не наследуется!
     */
    static final function deleteAll()
    {
        $sql = "DELETE FROM specialist ";

        if (!$st = Cfg::getDB()->prepare($sql)) {
            die('Не удалось подготовить запрос на кудаление всех специалистов!');
        }


        if (!$st->execute()) {
            die('Не удалось выполнить запрос на кудаление всех специалистов!');
        }

    }



}