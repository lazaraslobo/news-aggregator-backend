<?php

namespace App\Services\Internal;
use App\Services\HttpService;
use Illuminate\Http\Request;
use \App\Services\Internal\CacheArticleSources;

//http://localhost/api/get-articles?sources=bbc~newyork~others&author=lobo&fromDate=1-08-2024&toDate=08-08-2024&category=politics&query=donald
class GetArticlesService
{
    private Request $request;

    private string $enumSource = 'sources';
    private string $enumAuthor = 'author';
    private string $enumDateFrom = 'fromDate';
    private string $enumDateTo = 'toDate';
    private string $enumCategory = 'category';
    private string $enumSearchKeyword = 'query';

    public function setRequest(Request $request): self{
        $this->request = $request;
        return $this;
    }

    public function process(){
        $queryParams = $this->request->all() ?? [];
        $querySources = explode('~', $queryParams[$this->enumSource] ?? []);
        $queryAuthor = $queryParams[$this->enumAuthor] ?? [];
        $queryDateFrom = $queryParams[$this->enumDateFrom] ?? [];
        $queryDateTo = $queryParams[$this->enumDateTo] ?? [];
        $queryCategory = $queryParams[$this->enumCategory] ?? [];
        $querySearchKeyword = $queryParams[$this->enumSearchKeyword] ?? [];
        return (new CacheArticleSources())->process();
    }
}
