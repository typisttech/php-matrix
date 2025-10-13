<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Releases;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Message\ResponseInterface;

class PhpNetReleases implements ReleasesInterface
{
    private const string ENDPOINT = 'https://www.php.net/releases/index.php';

    /** @var int[] */
    private const array MAJORS = [5, 7, 8];

    public function __construct(
        private readonly ClientInterface $http = new GuzzleHttpClient,
    ) {}

    /**
     * @return string[]
     */
    public function all(): array
    {
        $promises = [];
        foreach (self::MAJORS as $major) {
            $promises[$major] = $this->http->requestAsync('GET', self::ENDPOINT, [
                'query' => [
                    'json' => true,
                    'max' => 1000,
                    'version' => $major,
                ],
            ]);
        }

        /**
         * Wait for the requests to complete; throws a ConnectException
         * if any of the requests fail
         *
         * @var ResponseInterface[] $responses
         */
        $responses = Utils::unwrap($promises);

        $contents = array_map(
            static fn (ResponseInterface $response) => $response->getBody()->getContents(),
            $responses,
        );

        $releases = [];
        foreach ($contents as $content) {
            /** @var mixed[] $data */
            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

            $releases[] = array_keys($data);
        }

        $releases = array_merge(...$releases);
        $releases = array_filter($releases, 'is_string');
        $releases = array_filter($releases, static fn (string $release) => $release !== '');
        $releases = array_unique($releases);

        return array_values($releases);
    }
}
