<?

class MyDate
{

    /**
     * Генерит исключение, если дата не соответствует формату
     * @param string|null $format Строка формата
     * @param string|null $date Проверяемая дата
     * @throws Exception Ислючение при ошибке
     */
    static public function isCorrect(string $format = null, string $date = null)
    {
        if (!$format || !$date){
            throw new Exception('Не заданы Дата и/или Формат');
        }

        if (!DateTime::createFromFormat($format, $date)){
            throw new Exception('Дата не соответствует формату');
        }
    }


    /**
     * Останавливает выполнение, если дата не соответствует формату
     * @param string $format
     * @param string $date
     */
    static function checkOrDie(string $format, string $date)
    {

        try {
            MyDate::isCorrect($format, $date);
        } catch (Exception $e){
            echo ' Ошибка: ' . $e->getMessage() . '<br>';
            echo ' Подробности: ';
            print_r(DateTime::getLastErrors());
            die();
        }

    }


    /**
     * Конвертирует дату в формат для MySQL
     * @param string $format
     * @param string $date
     * @return string
     */
    static function prepareForDb(string $format, string $date)
    {

        try {
            MyDate::isCorrect($format, $date);
        } catch (Exception $e){
            echo ' Ошибка: ' . $e->getMessage() . '<br>';
            echo ' Подробности: ';
            print_r(DateTime::getLastErrors());
            die();
        }

        $date = DateTime::createFromFormat($format, $date);

        return $date->format('Y-m-d');

    }


};
