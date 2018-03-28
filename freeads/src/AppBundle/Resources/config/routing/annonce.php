<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('annonces_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Annonce:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('annonces_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Annonce:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('annonces_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Annonce:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('annonces_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Annonce:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('annonces_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Annonce:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
