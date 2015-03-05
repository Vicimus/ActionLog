<?php

use DealerLive\Core\Classes\NavigationItem;
use DealerLive\Core\Classes\NavigationManager;

$navigation = NavigationManager::find('Reporting');

/*
$child = new NavigationItem('Notifications');
$child->setURL(\URL::to('dashboard/actionlog/errors/notifications'));
$child->setPackage('Action Log');
$navigation->addChild($child);

$child = new NavigationItem('View Error Log');
$child->setURL(\URL::to('dashboard/actionlog/errors'));
$child->setPackage('Action Log');
$navigation->addChild($child);

$child = new NavigationItem('View Page Data');
$child->setURL(\URL::to('dashboard/actionlog/report/pages'));
$child->setPackage('Action Log');
$navigation->addChild($child);*/