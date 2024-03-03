<?php 
namespace App\Tests;

trait RoleAdmin {
    public function setUp()
    {
        parent::setUp();

        self::bootKernel();
        $container = self::$kernel->getContainer();
        $container = self::$container;
        $cache = self::$container->get('App\Utils\Interfaces\CacheInterface');
        $this->cache = $cache->cache;
        $this->cache->clear();

        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'jw@symf4.loc',
            'PHP_AUTH_PW' => 'passw'
        ]);

        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function tearDown()
    {
        $this->cache->clear();
        parent::tearDown();  
        $this->entityManager->close();    
        $this->entityManager = null; // avoid memory leaks   
    }
}