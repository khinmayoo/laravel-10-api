<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Models\Article\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ArticleController extends APIBaseController
{
    protected $articleRepository;

    public function __construct(Request $request, ArticleRepositoryInterface $articleRepository)
    {
        $this->method = $request->getMethod();
        $this->endpoint = $request->path();
        $this->startTime = microtime(true);
        $this->articleRepository = $articleRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->offset = isset($request->offset) ? $request->offset : 0;
        $this->limit = isset($request->limit) ? $request->limit : 30;

        $articles = $this->articleRepository->get($this->offset, $this->limit);

        $total = $this->articleRepository->count();
        $this->data = $articles;
        $this->total = $total;
        return $this->response('200');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        try {
            $article = $this->articleRepository->create($request->all());

            if (isset($article)) {
                $this->data(['id' => $article->id]);
                return $this->response('201');
            }
        } catch (\Exception $e) {
            Log::error('Article creating has occurs error'. $e);
            $this->setErrors('400');
            return $this->response('400');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = $this->articleRepository->getById($id);
        if ($article->isEmpty()) {
            $this->setErrors('404', $id);
            return $this->response('404');
        } else {
            $this->data($article->toArray());
            return $this->response('200');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->only('title', 'body');
        $validator = Validator::make($data, [
            'title' => 'unique:articles|max:255',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $this->setErrors('400', $id);
            return $this->response('400');
        }

        $article = $this->articleRepository->findById($id);

        if (empty($article)) {
            $this->setErrors('404', $id);
            return $this->response('404');
        } else {
            $article->update($data);
            $this->data(['updated' => 1]);
            return $this->response('200');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = $this->articleRepository->findById($id);
        if (empty($article)) {
            $this->setErrors('404', $id);
            return $this->response('404');
        } else {
            $article->delete();
            $this->data(['deleted' => 1]);
            return $this->response('200');
        }
    }
}
