<?php

namespace App\Services\Views;

use App\Helpers\RedisHelper;
use App\Services\Internal\CacheArticleSources;

class DashboardViewService
{
    public function process(){
        $articlesData = RedisHelper::get(CacheArticleSources::ALL_SOURCES_DATA_MAPPED_CACHE_PREFIX) ?? [];
        $mappedAuthors = RedisHelper::get(CacheArticleSources::ALL_AUTHORS_CACHE_PREFIX) ?? [];
        $mappedSourceNames = RedisHelper::get(CacheArticleSources::ALL_SOURCES_NAMES_CACHE_PREFIX) ?? [];

        return [
            'topics' => CacheArticleSources::TOPICS,
            'articles' => $articlesData,
            'authors' => $mappedAuthors,
            'sources' => $mappedSourceNames
        ];
    }
}
