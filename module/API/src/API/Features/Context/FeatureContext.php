<?php
namespace API\Features\Context;


use API\Features\Fixtures\LoadBeachData;
use API\Features\Fixtures\LoadCityData;
use API\Features\Fixtures\LoadCommentData;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\Step\Given;
use Behat\Behat\Exception\PendingException;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\SchemaTool;
use MvLabs\Zf2Extension\Context\Zf2AwareContextInterface;
use Symfony\Component\Finder\Finder;
use Zend\Mvc\Application;

//
// Require 3rd-party libraries here:
//
// require_once 'PHPUnit/Autoload.php';
//

require __DIR__ . '/../../../../../../vendor/autoload.php';


/**
 * Feature context.
 */
class FeatureContext extends BehatContext implements Zf2AwareContextInterface
{
    private $zf2MvcApplication;
    private $parameters;


    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->useContext('WebAPI', new WebApiContext($parameters['baseUrl']));
    }

    /**
     * Sets Zend\Mvc\Application instance.
     * This method will be automatically called by Zf2Extension ContextInitializer.
     *
     * @param Zend\Mvc\Application $zf2MvcApplication
     */
    public function setZf2App(Application $zf2MvcApplication)
    {
        $this->zf2MvcApplication = $zf2MvcApplication;
    }


    public function getServiceManager()
    {
        return $this->zf2MvcApplication->getServiceManager();
    }


    /**
     * @Given /^there are (\d+) \'([^\']*)\' in the system$/
     */
    public function thereAreInTheSystem($itemNr, $entityName)
    {

        $em = $this->getEntityManager();
        $itemRepo = $em->getRepository('API\Entity\\' . $entityName);
        $items = $itemRepo->findAll();
        \PHPUnit_Framework_Assert::assertSame((int)$itemNr, sizeof($items));
    }


    /**
     * @Given /^I should have (\d+) \'([^\']*)\' in my system$/
     */
    public function iShouldHaveInMySystem($arg1, $arg2)
    {
        throw new PendingException();
    }

    public function getEntityManager()
    {
        return $this->getServiceManager()->get('doctrine.entitymanager.orm_default');
    }

    /**
     * @Given /^(\d+) saved images$/
     */
    public function savedImages($imageNr)
    {
        $finder = new Finder();
        $sourcePath = __DIR__ . '/../' . $this->parameters['testImagePath'];
        $iterator = $finder->files()->in($sourcePath);
        \PHPUnit_Framework_Assert::assertSame((int)$imageNr, $iterator->count());
    }

    /**
     * @BeforeScenario
     */
    public function restoreDb()
    {
        unlink(__DIR__. '/../../../../../../data/pics/1.jpg');
        $em = $this->getEntityManager();
        $tool = new SchemaTool($em);
        $metaData = $em->getMetadataFactory()->getAllMetadata();
        $tool->dropSchema($metaData);
        $tool->createSchema($metaData);
    }


    /**
     * @Given /^I have (\d+) \'([^\']*)\' on my system$/
     */
    public function iHaveOnMySystem($itemNr, $entityName)
    {
        $fixtures = array();
        switch($entityName){
            case 'Beach':
                $fixtures = array(
                    new LoadCityData(),
                    new LoadBeachData()
                );
                break;
            case 'Comment':
                $fixtures = array(
                    new LoadCityData(),
                    new LoadBeachData(),
                    new LoadCommentData()
                );
                break;
            case 'City':
                $fixtures = array(
                    new LoadCityData(),
                );
                break;
        }

        $this->loadFixtures($fixtures);

    }

    /**
     * @Given /^(\d+) of it is from a beach from "([^"]*)"$/
     */
    public function ofItIsFromABeachFrom($arg1, $arg2)
    {

    }

    private function loadFixtures(array $fixtures)
    {
        $loader = new Loader();
        foreach ($fixtures as $fixture) {
            $loader->addFixture($fixture);
        }
        $em = $this->getEntityManager();
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }

}
