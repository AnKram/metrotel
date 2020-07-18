<?php

class ModelContacts extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $id
     * @param string $sort
     * @param string $sequence
     * @return array|null
     */
    public function getContactListByUserId(int $id, string $sort = 'name', string $sequence = 'ASC'): ?array
    {
        $sql = '
            SELECT `id`, `name`, `surname`, `first_number`, `second_number`, `email`, `image` 
            FROM `directory_entries`
            WHERE `user_id` = ' . $id . '
            ORDER BY `' . $sort . '` ' . $sequence . ';';

        return $this->db_conn->query($sql)->fetchAll();
    }

    /**
     * @param int $user_id
     * @param int $id
     * @return array|null
     */
    public function getContactById(int $user_id, int $id): ?array
    {
        $sql = '
            SELECT * 
            FROM `directory_entries`
            WHERE `user_id` = ' . $user_id . '
            AND `id` = ' . $id . ';';

        $result = $this->db_conn->query($sql)->fetch();
        return $result ? $result : null;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function createContact(array $data): bool
    {
        $surname = $data['surname'] ? '"' . $data['surname'] . '"' : 'NULL';
        $first_number = $data['num1'] ? '"' . $data['num1'] . '"' : 'NULL';
        $second_number = $data['num2'] ? '"' . $data['num2'] . '"' : 'NULL';
        $email = $data['email'] ? '"' . $data['email'] . '"' : 'NULL';
        $image = $data['image'] ? '"' . $data['image'] . '"' : 'NULL';

        $sql = '
            INSERT INTO `directory_entries` (
                `user_id`, 
                `name`, 
                `surname`, 
                `first_number`, 
                `second_number`, 
                `email`, 
                `image`, 
                `date_added`, 
                `date_updated`
            ) 
            VALUES (
                "' . $data['user_id'] . '", 
                "' . $data['name'] . '", 
                ' . $surname . ', 
                ' . $first_number . ', 
                ' . $second_number . ', 
                ' . $email . ', 
                ' . $image . ', 
                NOW(), 
                NOW()
            );';

        return $this->db_conn->prepare($sql)->execute();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateContact(array $data): bool
    {
        $surname = $data['surname'] ? '"' . $data['surname'] . '"' : 'NULL';
        $first_number = $data['num1'] ? '"' . $data['num1'] . '"' : 'NULL';
        $second_number = $data['num2'] ? '"' . $data['num2'] . '"' : 'NULL';
        $email = $data['email'] ? '"' . $data['email'] . '"' : 'NULL';
        $image = $data['image'] ? '"' . $data['image'] . '"' : 'NULL';

        $sql = '
            UPDATE `directory_entries`
            SET `name` = "' . $data['name'] . '", 
            `surname` = ' . $surname . ', 
            `first_number` = ' . $first_number . ', 
            `second_number` = ' . $second_number . ', 
            `email` = ' . $email . ', 
            `image` = ' . $image . ', 
            `date_updated` = NOW() 
            WHERE `id` = ' . $data['id'] . ';';

        return $this->db_conn->prepare($sql)->execute();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delContact(int $id): bool
    {
        $sql = '
            DELETE FROM `directory_entries` 
            WHERE `id` = ' . $id . ';';

        return $this->db_conn->prepare($sql)->execute();
    }
}