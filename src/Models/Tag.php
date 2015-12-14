<?php namespace Models;
    class Tag extends Model
    {
        protected $table="tags";
        
        public function productTags($product_id)
        {

            $sql = sprintf('SELECT * FROM tags as t INNER JOIN product_tag as pt ON t.id = pt.tag_id WHERE pt.product_id=%d', (int) $product_id);
            $stmt = $this->pdo->query($sql);

            if(!$stmt) return false;
            return $stmt->fetchAll();
        }
    }