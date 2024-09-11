<?php

namespace App\Http\Controllers;

use App\Services\Internal\GetArticlesService;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function getArticles(
        Request $request,
        GetArticlesService $getArticlesService
    ){
        $response = $getArticlesService->setRequest($request)->process();
        return $response;
    }
}
