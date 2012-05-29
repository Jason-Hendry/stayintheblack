<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


  public function initTZ() {
    date_default_timezone_set('Australia/Melbourne');
  }

  public function _initDoctrine() {
    $lib = realpath(dirname(__FILE__).'/../library');
    require "Doctrine/Common/ClassLoader.php";
    $doctrineCommonLoader = new \Doctrine\Common\ClassLoader("Doctrine\Common",$lib);
    $doctrineCommonLoader->register();
    $dbalLoader = new \Doctrine\Common\ClassLoader("Doctrine\DBAL",$lib);
    $dbalLoader->register();
    $ormLoader = new \Doctrine\Common\ClassLoader("Doctrine\ORM",$lib);
    $ormLoader->register();
    $applicationLoader = new \Doctrine\Common\ClassLoader("Application",realpath(APPLICATION_PATH.'/../'));
    $applicationLoader->register();

    // Fetch Application Config Options
    $conf = $this->getApplication()->getOptions();
 
    //TODO Setup ApcCache on production
    $cache = new \Doctrine\Common\Cache\ArrayCache();
    $config = new \Doctrine\ORM\Configuration();
    $config->setMetadataCacheImpl($cache);
    $driverImpl = $config->newDefaultAnnotationDriver($conf['doctrine']['entities']);
    $config->setMetadataDriverImpl($driverImpl);
    $config->setQueryCacheImpl($cache);
    $config->setProxyDir($conf['doctrine']['proxyPath']);
    $config->setProxyNamespace($conf['doctrine']['proxyNamespace']);
    //TODO disable on production
    $config->setAutoGenerateProxyClasses(true);

    $em = \Doctrine\ORM\EntityManager::create($conf['doctrine']['connection'],$config);
   
    return $em;
  }
  public function _initDocType() {
    $this->bootstrap('view');
    $view = $this->getResource('view');
    $view->docType('HTML5');
  }

}

