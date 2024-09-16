<?php

namespace App\Responses;

class CacheArticlesResponse
{
    public const NEWS_API_TYPE = 'news-api';
    public const NEW_YORK_TIMES_API_TYPE = 'NYT-api';
    public const GUARDIAN_API_TYPE = 'guardian-api';

    public const dateFormat = 'Y-m-d';

    public function getResponse(array $response, string $type, string $topic = '')
    {
        switch ($type) {
            case self::NEWS_API_TYPE:
                return $this->getNewsApiResponse($response, $topic);
            case self::NEW_YORK_TIMES_API_TYPE:
                return $this->getNYTApiResponse($response, $topic);
            case self::GUARDIAN_API_TYPE:
                return $this->getGuardianApiResponse($response, $topic);
        }
    }

    private function getNewsApiResponse(array $response = [], string $topic): array
    {
        $result = [];
        $authors = [];
        $sources = [];
        collect($response['body']['articles'] ?? [])->each(function ($item)
        use (&$result, &$authors, &$sources, $topic) {
            $author = $item['author'] ?? $item['source']['name'] ?? 'Unknown';

            if (!isset($result[$topic])) {
                $result[$topic] = [];
            }

            if (!isset($result[$topic][$author])) {
                $result[$topic][$author] = [];
            }

            $result[$topic][$author][] = [
                "source" => $item['source']['name'] ?? "",
                "title" => $item['title'] ?? "",
                "description" => $item['description'] ?? "",
                "url" => $item['url'] ?? "",
                "imageSrc" => $item['urlToImage'] ?? "",
                "publishedAt" => (new \DateTime($item['publishedAt']))->format(self::dateFormat),
                "content" => $item['content'] ?? "",
                "topic" => $topic,
                "author" => $author,
                "whichAPi" => "Open News"
            ];

            $sources[$item['source']['name']] = $sources[$item['source']['name']] ?? 0;
            $sources[$item['source']['name']]++;

            $authors[$author] = $authors[$author] ?? 0;
            $authors[$author]++;

        });

        return [
            "results" => $result,
            "authors" => $authors,
            "sources" => $sources,
        ];
    }


    private function getNYTApiResponse(array $response)
    {

    }

    private function getGuardianApiResponse(array $response, string $topic)
    {
        $result = [];
        $authors = [];
        $sources = [];
        collect($response['body']['response']['results'] ?? [])->each(function ($item)
        use (&$result, &$authors, &$sources, $topic) {
            $itemFields = $item['fields'] ?? [];
            $author = $itemFields['byline'] ?? $item['pillarName'] ?? 'Unknown';

            if (!isset($result[$topic])) {
                $result[$topic] = [];
            }

            if (!isset($result[$topic][$author])) {
                $result[$topic][$author] = [];
            }

            $result[$topic][$author][] = [
                "source" => $item['pillarName'] ?? "",
                "title" => $item['webTitle'] ?? "",
                "description" => "-",
                "url" => $item['webUrl'] ?? "",
                "imageSrc" => $itemFields['thumbnail'] ?? "",
                "publishedAt" => (new \DateTime($itemFields['lastModified']))->format(self::dateFormat),
                "content" => $itemFields['bodyText'] ?? "",
                "topic" => $topic,
                "author" => $author,
                "whichAPi" => "Guardians"
            ];

            $sources[$item['pillarName']] = $sources[$item['pillarName']] ?? 0;
            $sources[$item['pillarName']]++;

            $authors[$author] = $authors[$author] ?? 0;
            $authors[$author]++;

        });

        return [
            "results" => $result,
            "authors" => $authors,
            "sources" => $sources,
        ];
    }
}
