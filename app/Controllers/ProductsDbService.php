<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Controllers;

use App\Kernel\DbManager;
use PDO;

/**
 * Class ProductsDbService provides functions for CRUD operations.
 */
class ProductsDbService extends DbManager
{
    /**
     * Create a product.
     *
     * @param $data 'name' and 'key' are required, and must been already been validate for uniqueness.
     *
     * @return mixed
     */
    public function create($data)
    {
        $query =
            'INSERT INTO `'.getenv('DB_NAME').'`.`products` (`name`, `slug`, `price`, `description`) 
            VALUES (:name, :slug, :price, :description);';

        $name = $data['name'];
        $slug = $data['slug'];
        $price = isset($data['price']) ? $data['price'] : null;
        $description = isset($data['description']) ? $data['description'] : null;

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':slug', $slug, PDO::PARAM_STR);
        $statement->bindParam(':price', $price, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->execute();

        return $this->getConnection()->lastInsertId();
    }
}