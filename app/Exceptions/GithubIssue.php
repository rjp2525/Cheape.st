<?php

namespace Cheapest\Exceptions;

use Github\Api\Issue;
use Github\Api\Search;
use Github\Client as GithubClient;
use Github\Exception\InvalidArgumentException;
use Github\Exception\MissingArgumentException;

class GithubIssue
{
    const READABLE_TITLE_LENGTH = 50; // My arbitrary personal belief, feel free to disagree

    private $number;
    private $url;
    private $title;
    private $body;

    /**
     * GithubIssue constructor.
     * Internally formats the Github issue title and message
     * @param string $message
     * @param int $code
     * @param int $severity
     * @param string $path
     * @param int $lineno
     * @param string $trace
     */
    public function __construct($message = null, $code = null, $severity = null, $path = null, $lineno = null, $trace = null)
    {
        // Default message
        if (null === $message) {
            $message = 'An error occured.';
        }
        // Format the title under 50 characters
        $this->title = GithubIssue::formatTitle($path, $lineno, $message);
        // Only display a two-parent-directories-deep path, for readability
        $short_path = GithubIssue::formatPath($path);
        $body_content = [];
        // Head table (Code and Severity)
        if (null !== $code || null !== $severity) {
            $body_content[] = GithubIssue::formatTable($code, $severity);
        }
        // $path:$line
        if (null !== $path) {
            $path_text = '**Path**' . PHP_EOL . $short_path;
            if (null !== $lineno) {
                $path_text .= ':**' . $lineno . '**';
            }
            $body_content[] = $path_text;
        }
        if (null !== $message) {
            $body_content[] = '**Message**' . PHP_EOL . $message;
        }
        if (null !== $trace) {
            $body_content[] = '**Stack trace**' . PHP_EOL . '```' . PHP_EOL . $trace . PHP_EOL . '```';
        }
        // Format the body
        $this->body = GithubIssue::formatBody($body_content);
    }

    /**
     * Formats the issue's title
     * @param $path
     * @param $lineno
     * @param $message
     * @return string
     */
    private static function formatTitle($path, $lineno, $message)
    {
        $title = '';
        // [basename($path):$line] $short_message
        if (null !== $path) {
            $title .= '[' . basename($path);
            if (null !== $lineno) {
                $title .= ':' . $lineno;
            }
            $title .= '] ';
        }
        $short_message = $message;
        if (mb_strlen($message) >= GithubIssue::READABLE_TITLE_LENGTH) {
            $short_message = mb_substr($message, 0, GithubIssue::READABLE_TITLE_LENGTH - 1) . '…';
        }
        $title .= $short_message;
        return $title;
    }

    /**
     * Formats the issue's path
     * @param $path
     * @return string
     */
    private static function formatPath($path)
    {
        $dirs = explode(DIRECTORY_SEPARATOR, $path);
        return '..' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, array_slice($dirs, count($dirs) - 3));
    }

    /**
     * Formats the issues table
     * @param $code
     * @param $severity
     * @return string
     */
    private static function formatTable($code, $severity)
    {
        $display_code = null !== $code;
        $display_severity = null !== $severity;
        $table_title = '';
        $table_content = '';
        $table_divider = '---';
        if ($display_code && $display_severity) {
            $table_title = 'Code | Severity';
            $table_divider = ':---: | :---:';
            $table_content = $code . ' | ' . $severity;
        } else if ($display_code) {
            $table_title = 'Code';
            $table_content = $code;
        } else if ($display_severity) {
            $table_title = 'Severity';
            $table_content = $severity;
        }
        return '| ' . $table_title . ' |' . PHP_EOL . '| ' . $table_divider . ' |' . PHP_EOL . '| ' . $table_content . ' |';
    }

    /**
     * Formats the issue's body
     * @param array $body_content
     * @return string
     */
    private static function formatBody(array $body_content)
    {
        return implode(PHP_EOL . PHP_EOL, $body_content);
    }

    /**
     * Actually creates the issue on Github, returns an array with the issue's number and URL.
     * @param $username
     * @param $password
     * @param $repo_author
     * @param $repo_name
     * @return array
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     * @throws ErrorException
     */
    public function commit($username, $password, $repo_author, $repo_name)
    {
        $client = new GithubClient();
        $client->authenticate($username, $password, GithubClient::AUTH_HTTP_PASSWORD);
        $search_api = $client->api('search');
        $issue_api = $client->api('issue');
        // Check existing issues to avoid duplicates
        $duplicates = $search_api->issues($this->title . ' in:title label:bug repo:' . $repo_author . '/' . $repo_name);
        if ((int) $duplicates['total_count'] > 0) {
            return ['duplicate' => true];
        }
        // Create the issue and fetch the issue's info
        $issue_info = $issue_api->create(
            $repo_author,
            $repo_name, [
                'title' => $this->title,
                'body'  => $this->body
            ]
        );
        if (!array_key_exists('number', $issue_info) || !array_key_exists('url', $issue_info)) {
            throw new ErrorException('Missing Github issue info parameter');
        }
        // Apply the "Bug" label
        $issue_api->labels()->add($repo_author, $repo_name, $issue_info['number'], 'bug');
        $this->number = $issue_info['number'];
        $this->url = $issue_info['url'];
        return ['duplicate' => false, 'number' => $this->number, 'url' => $this->url];
    }
}
