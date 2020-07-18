<?php

class ModelUser extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $data
     * @return int|null
     */
    public function setUser(array $data): ?int
    {
        $sql = '
            INSERT INTO `directory_users` (`login`, `pass`, `email`, `date_added`) 
            VALUES ("' . $data['login'] . '", "' . $data['pass'] . '", "' . $data['email'] . '", NOW());';

        $this->db_conn->prepare($sql)->execute();

        return $this->db_conn->lastInsertId();
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function getUser(array $data): ?array
    {
        $sql = '
            SELECT * 
            FROM `directory_users` 
            WHERE `' . $data['identify'] . '` = "' . $data['identify_val'] . '"
            AND `pass` = "' . $data['pass'] . '";';

        return $this->db_conn->query($sql)->fetch();
    }

    /**
     * @param string $val
     * @param string $column
     * @return bool
     */
    public function checkUniq(string $val, string $column): bool
    {
        $sql = '
            SELECT `email` 
            FROM `directory_users`
            WHERE `' . $column . '` = "' . $val . '";';

        $result = $this->db_conn->query($sql)->fetchAll();

        return !empty($result) ? false : true;
    }
}