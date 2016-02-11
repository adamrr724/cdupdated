<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/CD.php";
    require_once __DIR__."/../src/Artist.php";


    session_start();
    if (empty($_SESSION['cd_list'])) {
        $_SESSION['cd_list'] = array();
    }

    $app = new Silex\Application();

    // $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array (
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app){
      return $app['twig']->render('display.html.twig');
    });

    $app->post("/show", function() use ($app) {
        $cd = new CD($_POST['title'], new Artist($_POST['artist']));
        $cd->save();
        return $app['twig']->render('display.html.twig', array('cds' => CD::getAll()));
    });

    $app->post("/clear", function() use ($app){
        CD::reset();
        return $app['twig']->render('display.html.twig', array('cds' => CD::getAll()));
    });

    $app->get("/cd_search", function() use ($app){
        $cds = CD::getAll();
        $search_return = array();
        $search = strtolower($_GET['artist']);
        foreach($cds as $cd) {
            $this_artist = $cd->getArtist();
            $artist = strtolower($this_artist->getName());
            if ($cd->matchArtist($artist, $search)) {
                array_push($search_return, $cd);
            }
        }
        return $app['twig']->render('displaysearch.html.twig', array('cds' => $search_return));
    });

    $app->get("/new", function() use ($app){
      return $app['twig']->render('new_cd.html.twig');
    });

    $app->get("/list", function() use ($app){
      return $app['twig']->render('display.html.twig', array('cds' => CD::getAll()));
    });

    $app->get("/search", function() use ($app){
      return $app['twig']->render('searchbyartist.html.twig');
    });

    return $app;

?>
