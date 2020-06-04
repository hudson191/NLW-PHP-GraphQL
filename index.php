<?php

require_once 'vendor/autoload.php';

use Siler\Graphql;
use GraphQL\GraphQL as WGraphql;
use Siler\Http\Request;
use Siler\Http\Response;
use Overblog\DataLoader\DataLoader;
use Overblog\DataLoader\Promise\Adapter\Webonyx\GraphQL\SyncPromiseAdapter;
use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter;

Response\header('Access-Control-Allow-Origin', '*');
Response\header('Access-Control-Allow-Headers', 'content-type');


$graphQLSyncPromiseAdapter = new SyncPromiseAdapter();
$promiseAdapter = new WebonyxGraphQLSyncPromiseAdapter($graphQLSyncPromiseAdapter);

WGraphQL::setPromiseAdapter($graphQLSyncPromiseAdapter);

if (Request\method_is('post')) {
    $schema = include __DIR__.'/schema.php';

    Graphql\init($schema);
}
