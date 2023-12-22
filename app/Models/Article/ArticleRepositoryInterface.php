<?php

namespace App\Models\Article;

interface ArticleRepositoryInterface
{
    public function get($offset, $limit);

    public function count();

    public function getById($id);

    public function findById($id);

    public function update($parms, $id);

    public function create($params);

    public function delete($params);
}