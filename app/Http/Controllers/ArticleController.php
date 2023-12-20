<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends APIBaseController
{
    public function __construct(Request $request)
    {
        $this->method = $request->getMethod();
        $this->endpoint = $request->path();
        $this->startTime = microtime(true);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->offset = isset($request->offset) ? $request->offset : 0;
        $this->limit = isset($request->limit) ? $request->limit : 30;

        $articles = Article::orderBy('created_at', 'desc')
        ->skip($this->offset)
        ->take($this->limit)
        ->get()->toArray();

        $total = Article::count();
        $this->data = $articles;
        $this->total = $total;
        return $this->response('200');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
