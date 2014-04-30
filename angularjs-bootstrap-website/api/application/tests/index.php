<?php
/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
if ( ! defined('SUPPRESS_REQUEST'))
{
    echo Request::factory()
        ->execute()
        ->send_headers()
        ->body();
}