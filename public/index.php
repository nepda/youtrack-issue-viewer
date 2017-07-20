<?php
/**
 * nepda Internetdienstleistungen
 * Nepomuk Fraedrich
 * http://nepda.eu/
 *
 * PHP Version >= 7.0
 *
 * @author Nepomuk Fraedrich <info@nepda.eu>
 */

require_once '../vendor/autoload.php';
include_once '../.config.php';

$app = new \Slim\App;

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../views');

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};


$app->get('/', function (
    \Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response
) {
    return $this->view->render($response, 'landing.twg');
});

$app->get('/{issueId}', function (
    \Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response
) {

    $id = $request->getAttribute('issueId');

    $yt = new YouTrack\Connection(YOUTRACK_URL, YOUTRACK_USERNAME, YOUTRACK_PASSWORD);

    $i = $yt->getIssue($id, ['wikifyDescription' => 'true']);

    $txt = $i->getDescription();

    $txt = preg_replace('/"\/youtrack\/issue\/(.*)"/Usi', '"/$1"', $txt);

    $txt = str_replace(' href="/youtrack/', ' href="' . YOUTRACK_URL . '/', $txt);

    return $this->view->render($response, 'article.twg', [
        'issueId' => $i->getId(),
        'title' => $i->getSummary(),
        'description' => $txt,
        'youtrackBaseUrl' => YOUTRACK_URL
    ]);
});

$app->run();
