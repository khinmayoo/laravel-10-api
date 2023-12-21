<?php

namespace App\Models\Article;

use App\Models\Article\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Support\Facades\Input;
use App\Core\ReturnMessage;
use App\User;
use Auth;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function get($offset, $limit)
    {
        $articles = Article::orderBy('id', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get(['id', 'title', 'body'])->toArray();

        return $articles;    
    }

    public function count()
    {
        return Article::count();
    }
    public function getById($id)
    {
        return Article::where('id', $id)->get(['id', 'title', 'body']);
    }

    public function update($parms, $id)
    {

    }

    public function create($data)
    {
        return Article::create($data);
    }

    public function delete($params)
    {

    }
}
