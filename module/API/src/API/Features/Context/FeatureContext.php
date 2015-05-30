<?php
namespace API\Features\Context;


use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    API\Features\Context\WebApiContext,
    Behat\Behat\Exception\PendingException;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Doctrine\ORM\Tools\SchemaTool;
use MvLabs\Zf2Extension\Context\Zf2AwareContextInterface;

use Symfony\Component\Finder\Finder;
use Zend\Mvc\Application;

use Doctrine\Common\DataFixtures\Loader;
use API\Features\Fixtures\LoadCityData;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

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
        \PHPUnit_Framework_Assert::assertSame((int) $imageNr, $iterator->count());
    }

    /**
     * @BeforeScenario
     */
    public function restoreDb()
    {
        $em = $this->getEntityManager();
        $tool = new SchemaTool($em);
        $metaData = $em->getMetadataFactory()->getAllMetadata();
        $tool->dropSchema($metaData);
        $tool->createSchema($metaData);
        $loader = new Loader();
        $loader->addFixture(new LoadCityData());
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }
}
