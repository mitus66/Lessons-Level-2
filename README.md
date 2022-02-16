# Lessons-Level-2
QueryBuilder for Level 2

1. Это элементарный построитель запросов к базе данных

2. Файл config.php содержит данные для соединения с БД
return [
    'database' => [
        'database' => 'test',
        'username' => 'root',
        'password' => '',
        'connection' => 'mysql:host=localhost',
        'charset' => 'utf8'
    ]
];

3. Эти данные используются в классе Connection, который возвращает $pdo
class Connection
{
    public static function make($config)
    {
        // Создаем объект-соединение с базой данных
        return new \PDO(
            "{$config['connection']};dbname={$config['database']};charset={$config['charset']};",
            "{$config['username']}",
            "{$config['password']}"
        );

        return $pdo;
    }
}

4. Эти данные используются в основном классе копмонента QueryBuilder
class QueryBuilder
{
    protected $pdo;
    
    // создаем внутри этого класса экземпляр класса Connection
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    // получение всех записей из таблицы
    public function getAll($table)
    {
        $sql = "SELECT * FROM {$table}";
        $statament = $this->pdo->prepare($sql);
        $statament->execute();

        // Получаем данные результата запроса:
        return $statament->fetchAll(PDO::FETCH_ASSOC);
    }

    // получение одной записи из таблицы
    public function getOne($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // сздание одной записи в таблице
    public function create($table, $data)
    {
        $keys = implode(',', array_keys($data));
        $tags = ":" . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$keys}) VALUE ({$tags})";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    // редактирование записи в таблице
    public function update($table, $data, $id)
    {
        $keys = array_keys($data);
        $string = '';

        foreach ($keys as $key) {
            $string .= $key . '=:' . $key . ',';
        }

        $keys = rtrim($string, ',');
        $data['id'] = $id;

        $sql = "UPDATE {$table} SET {$keys} WHERE id=:id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    // удаление записи из таблицы
    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

}

5. Обращение к методам класса производится с помощью запросов:
$post = $db->getOne($table, $id); - для получения одногй записи
$posts = $db->getAll($table); - для получения всех записей
$db->create($table, ['title' => $_POST['title'] ]); - для создания записи
$db->update($table, $_POST, $_GET['id']); - для редактирования записи
$db->delete($table, $id); - для удаления записи
