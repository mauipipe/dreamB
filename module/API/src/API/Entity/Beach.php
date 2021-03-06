<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="API\Entity\Repository\BeachRepository")
 * @ORM\Table(name="beach")
 */
class Beach
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
     * @ORM\ManyToOne(targetEntity="City", inversedBy="beaches")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     **/
    protected $city;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="beach")
     **/
    protected $comments;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $slug;

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
     * @return Beach
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
     * @return Beach
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
     * Set city
     *
     * @param \API\Entity\City $city
     *
     * @return Beach
     */
    public function setCity(\API\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \API\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comment
     *
     * @param \API\Entity\Comment $comment
     *
     * @return Beach
     */
    public function addComment(\API\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \API\Entity\Comment $comment
     */
    public function removeComment(\API\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function getCityName()
    {
        return $this->city->getName();
    }
}
