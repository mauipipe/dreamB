<?php
namespace API\Features\Context;


use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    API\Features\Context\WebApiContext,
    Behat\Behat\Exception\PendingException;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use MvLabs\Zf2Extension\Context\Zf2AwareContextInterface;

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
    private $entities = array();

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

        throw new PendingException();
    }


    /**
     * @Given /^I should have (\d+) \'([^\']*)\' in my system$/
     */
    public function iShouldHaveInMySystem($arg1, $arg2)
    {
        throw new PendingException();
    }
}
