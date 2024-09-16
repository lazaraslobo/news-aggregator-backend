<?php

namespace App\Services\Internal;
use App\Helpers\RedisHelper;
use App\Responses\CacheArticlesResponse;
use App\Services\External\HttpService;

class CacheAllArticleSourcesService
{

    public const ALL_AUTHORS_CACHE_PREFIX = 'cache-article-topic-authors:';

    public const ALL_SOURCES_DATA_MAPPED_CACHE_PREFIX = 'cache-mapped-sources-data';

    public const ALL_SOURCES_NAMES_CACHE_PREFIX = 'cache-mapped-sources-names';


    //these are static for now, we can make them from CMS and redis cache these
    public const TOPICS = [
        "politics", "sports", "technology",
//        "health", "business", "entertainment",
//        "science", "world", "economy", "finance", "education", "environment",
//        "travel", "food", "culture", "law", "government", "elections", "medicine",
//        "startup", "art", "music", "movies", "television", "crime", "weather",
//        "space", "innovation", "social media", "cybersecurity", "energy", "housing",
//        "real estate", "military", "immigration", "climate change", "pandemic",
//        "aviation", "trade", "infrastructure", "justice", "human rights",
//        "nonprofit", "agriculture", "banking", "retail", "pharmaceuticals",
//        "transportation", "technology trends", "diplomacy", "conflict", "war",
//        "peace", "civil rights", "terrorism", "nuclear", "e-commerce", "marketing",
//        "advertising", "luxury", "consumer goods", "personal finance", "credit",
//        "insurance", "investment", "stock market", "bonds", "mutual funds",
//        "cryptocurrency", "blockchain", "artificial intelligence", "machine learning",
//        "robotics", "internet of things", "big data", "cloud computing", "quantum computing",
//        "5G", "telecommunications", "data privacy", "biotechnology", "genetics",
//        "telemedicine", "mental health", "nutrition", "fitness", "disease", "surgery",
//        "pharmaceutical research", "renewable energy", "solar power", "wind power",
//        "electric vehicles", "self-driving cars", "smart cities", "drones",
//        "space exploration", "space tourism", "global warming", "biodiversity",
//        "water scarcity", "ocean pollution", "deforestation", "natural disasters",
//        "earthquakes", "floods", "wildfires", "hurricanes", "volcanoes", "environmental policy",
//        "sustainable development", "urban planning", "architecture", "design",
//        "fashion", "beauty", "lifestyle", "fitness", "relationships", "parenting",
//        "childcare", "pets", "animal rights", "wildlife", "agricultural technology",
//        "food security", "genetically modified organisms", "organic farming",
//        "climate policy", "renewable resources", "waste management", "recycling",
//        "public health", "epidemiology", "vaccine development", "healthcare reform",
//        "universal healthcare", "poverty", "inequality", "income disparity",
//        "minimum wage", "social justice", "civil liberties", "freedom of speech",
//        "press freedom", "censorship", "disinformation", "fake news", "fact-checking",
//        "whistleblowing", "freelance economy", "remote work", "gig economy",
//        "labor rights", "employment law", "workplace diversity", "gender equality",
//        "LGBTQ rights", "youth activism", "elder care", "retirement planning",
//        "pensions", "demographics", "cultural heritage", "world heritage sites",
//        "archaeology", "anthropology", "psychology", "philosophy", "ethics",
//        "religion", "spirituality", "interfaith dialogue", "historical analysis",
//        "biography", "literature", "poetry", "classical music", "jazz", "rock music",
//        "hip hop", "pop music", "theater", "ballet", "opera", "fine arts",
//        "modern art", "sculpture", "photography", "cinematography", "film industry",
//        "television production", "streaming services", "video games", "e-sports",
//        "comics", "animation", "VR/AR", "metaverse", "digital marketing",
//        "search engine optimization", "content creation", "influencer marketing",
//        "brand management", "public relations", "crisis management", "journalism",
//        "news writing", "investigative reporting", "opinion pieces", "editorials",
//        "cartoons", "satire", "memes", "viral content", "internet culture", "online privacy"
    ];


    public function process(){
        $httpService = new HttpService();
        $response = [];
        $authors = [];
        $sources = [];

        foreach ($this->getSourceMappings() as $eachSource){
            foreach (self::TOPICS as $eachTopic){
                $eachPageCount = 1;
                for($i = 0; $i < env('TOTAL_PAGES_TO_CACHE', 10); $i++){
                    $data = $httpService->get($eachSource['url'], [
                            $eachSource['queryIdentifier'] => $eachTopic,
                            $eachSource['keyIdentifier'] => $eachSource['apiKey'],
                            $eachSource['whichPageIdentifier'] => $eachPageCount,
                            ...($eachSource['params'] ?? [])
                        ]
                    ) ?? [];

                    //map data
                    $transformedData = (new CacheArticlesResponse())->getResponse($data, $eachSource['apiType'], $eachTopic);
                    $authors = [...$authors, ...$transformedData["authors"]];
                    $sources = [...$sources, ...$transformedData["sources"]];

                    //merge mapped data
                    foreach ($transformedData["results"] as $items) {
                        if (!isset($response[$eachTopic])) {
                            $response[$eachTopic] = [];
                        }

                        $response[$eachTopic] = array_merge($response[$eachTopic], $items);
                    }

                    $eachPageCount++;
                }
            }
        }

        if (!empty($sources) && !empty($response) && !empty($authors)) {
            RedisHelper::set(self::ALL_SOURCES_DATA_MAPPED_CACHE_PREFIX, $response, env("TWENTY_FOUR_HOURS_TTL_SECONDS"));
            RedisHelper::set(self::ALL_SOURCES_NAMES_CACHE_PREFIX, $sources, env("TWENTY_FOUR_HOURS_TTL_SECONDS"));
            RedisHelper::set(self::ALL_AUTHORS_CACHE_PREFIX, $authors, env("TWENTY_FOUR_HOURS_TTL_SECONDS"));
        }

        return $response;
    }

    private function getSourceMappings()
    {

        return [
            "news-api" => [
                "url" => "https://newsapi.org/v2/everything",
                "label" => "News API",
                "apiKey" => env("NEWS_API_KEY"),
                "queryIdentifier" => "q",
                "keyIdentifier" => "apiKey",
                "whichPageIdentifier" => 'page',
                "apiType" => CacheArticlesResponse::NEWS_API_TYPE
            ],
            "the-guardian-api" => [
                "url" => "https://content.guardianapis.com/search",
                "label" => "Guardian API",
                "apiKey" => env("THE_GUARDIAN_NEWS_API_KEY"),
                "queryIdentifier" => "q",
                "keyIdentifier" => "api-key",
                "whichPageIdentifier" => 'page',
                "apiType" => CacheArticlesResponse::GUARDIAN_API_TYPE,
                "params" => [
                    "show-fields" => "all"
                ]
            ],
            "NYT-api" => [
                "url" => "https://api.nytimes.com/svc/search/v2/articlesearch.json",
                "label" => "New York Time API",
                "apiKey" => env("NEW_YORK_TIMES_API_KEY"),
                "queryIdentifier" => "q",
                "keyIdentifier" => "api-key",
                "whichPageIdentifier" => 'page',
                "apiType" => CacheArticlesResponse::NEW_YORK_TIMES_API_TYPE,
                "params" => [
                ]
            ],
        ];
    }
}
