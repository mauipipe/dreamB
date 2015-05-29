<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="API\Entity\Repository\CityRepository")
 * @ORM\Table(name="city")
 */
class City
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Beach", mappedBy="city")
     **/
    protected $beaches;

    /**
     * @ORM\Column(type="text", length=200)
     */
    protected $slug;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->beaches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return City
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add beach
     *
     * @param \API\Entity\Beach $beach
     *
     * @return City
     */
    public function addBeach(\API\Entity\Beach $beach)
    {
        $this->beaches[] = $beach;

        return $this;
    }

    /**
     * Remove beach
     *
     * @param \API\Entity\Beach $beach
     */
    public function removeBeach(\API\Entity\Beach $beach)
    {
        $this->beaches->removeElement($beach);
    }

    /**
     * Get beaches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBeaches()
    {
        return $this->beaches;
    }
}
