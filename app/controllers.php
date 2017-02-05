    <?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

define('_STATIC', ROOT . '/static');

$app['top.menu'] = array(
    'title' => '',
    'actives' => array(),
    'root' => $config['page']['root'],
    'left' => require_once(_STATIC . '/top.menu.php'),
);
$app['side.menu'] = array(
    'items' => require_once(_STATIC . '/left.menu.php'),
    'actives' => array(),
    'root' => $config['page']['root'],
);


$app['twig']->addGlobal('page', $app['page']);
$app['twig']->addGlobal('sideMenu', $app['side.menu']);
$app['twig']->addGlobal('topMenu', $app['top.menu']);
$app['twig']->addGlobal('announcements', array());
$app['twig']->addGlobal('langUrlAppend', '/');


$app->get('/', function() use ($app){
    $posts = require_once(_STATIC . '/posts/recent-posts.php');
    $announcements = require_once(_STATIC . '/announcements.php');
    $allSections = require_once(_STATIC . '/all.sections.php');
    return $app['twig']->render('index.html.twig', array(
        'section' => null,
        'topSection' => null,
        'pageSection' => null,
        'sections' => $allSections,
        'posts' =>  $posts,
        'announcements' => $announcements,
    ));
});




$app->get('/{url}', function(Request $request, $url) use ($app){
    $subRequest = Request::create('/0/0/' . $url);
    return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
});

$app->get('/{page}/{url}', function(Request $request, $page, $url) use ($app){
    $subRequest = Request::create(sprintf('/0/%s/%s', $page, $url));
    return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
});

$app->get('/{top}/{page}/{url}', function(Request $request, $top, $page, $url) use ($app){
    $posts =  require_once(sprintf('%s/posts/%s/%s/%s.php', _STATIC, $top, $page, $url));
    $section = require_once(sprintf('%s/section/%s/%s.php', _STATIC, $page, $url));
    $topSection = null;
    $pageSection = null;
    $actives = array($section['id']);
    $urlPieces = array();
    if ($top) {
        $topSection = require_once(sprintf('%s/top/%s.php', _STATIC, $top));
        $actives[] = $topSection['id'];
        $urlPieces[] = $top;
    }
    if ($page) {
        $pageSection = require_once(sprintf('%s/page/%s.php', _STATIC, $page));
        $actives[] = $pageSection['id'];
        $urlPieces[] = $page;
    }
    $announcements = array();
    //$announcements = $app['announcement.service']->getSectionAnnouncements($section['id']);
    $urlPieces[] = $url;
    if (!in_array('consular', $urlPieces)) {
        $urlPieces = array();
    }

    $archives = null;

    return $app['twig']->render('posts.html.twig', array(
        'sideMenu' => array_merge($app['side.menu'], array('actives' => $actives)),
        'topMenu' => array_merge($app['top.menu'], array('actives' => $actives)),
        'posts' => $posts,
        'section' => $section,
        'topSection' => $topSection,
        'pageSection' => $pageSection,
        'sections' => $allSections = require_once(_STATIC . '/all.sections.php'),
        'announcements' => $announcements,
        'langUrlAppend' => '/' . join('/', $urlPieces),
        'archives' => $archives,
    ));
});

if ($config['env'] != 'dev') {
    $app->error(function (\Exception $e, $code) use ($app) {
        return $app['twig']->render('error.html.twig', array(
            'code' => $code,
        ));
    });
}

