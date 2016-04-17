<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Controllers;

use App\Kernel\DbManager;
use Database\migrations\ProductsTableMigration;
use PDO;

/**
 * Class ProductsDbService provides functions for CRUD operations.
 */
class ProductsDbService extends DbManager
{
    /**
     * Update a product if the given slug exists.
     * Create a product if the given slug does not exists.
     *
     * @param $data 'name' and 'slug' are required, and must been already been validate for uniqueness.
     * @param 'name' and 'slug' are required, and must been already been validate for uniqueness.
     *
     * @return mixed
     */
    public function updateOrCreate($data)
    {
        if (false !== ($fund = $this->findBySlug($data['slug']))) {
            return $this->updateBySlug($data, $data['slug']);
        }

        return $this->findById(
            $this->create($data)
        );
    }

    /**
     * Find a product given its slug.
     *
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        $query = 'SELECT * FROM `'.getenv('DB_NAME').'`.`'.ProductsTableMigration::TABLE_NAME.'` WHERE `slug` = :slug';

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':slug', $slug, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a product given its slug.
     *
     * @param $data 'name', 'slug' are required, and must been already been validate for uniqueness.
     * @param $oldSlug string Must be already validated for existence.
     * @return mixed
     */
    public function updateBySlug($data, $oldSlug)
    {
        $query =
            'UPDATE `'.getenv('DB_NAME').'`.`'.ProductsTableMigration::TABLE_NAME.'` 
             SET `name`=:name, `slug`=:slug, `price`=:price, `description`=:description 
             WHERE `slug`=:oldSlug;';

        $name = $data['name'];
        $slug = $data['slug'];
        $price = isset($data['price']) ? $data['price'] : null;
        $description = isset($data['description']) ? $data['description'] : null;

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':slug', $slug, PDO::PARAM_STR);
        $statement->bindParam(':price', $price, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':oldSlug', $oldSlug, PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * Find a product given its id.
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $query = 'SELECT * FROM `'.getenv('DB_NAME').'`.`'.ProductsTableMigration::TABLE_NAME.'` WHERE `id` = :id';

        $statement = $this->getConnection()->prepare($query);

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

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