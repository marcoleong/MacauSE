<?php
namespace MacauSE\Bundle\Organization\ProfileBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @MongoDB\Document(collection="profiles")
 */
class Profile
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @Assert\NotBlank
     * @MongoDB\String
     */
    protected $name;

    /**
     * @Gedmo\Slug(separator="-", updatable=true, fields={"name"})
     * @MongoDB\String
     */
    protected $slug;

    /**
     * @MongoDB\String
     * @Assert\Locale
     */
    protected $locale;

    /**
     * @var timestamp $created
     *
     * @MongoDB\Timestamp
     */
    protected $created;

    /**
     * @var date $updated
     *
     * @MongoDB\Date
     */
    protected $updated;

    /**
     * @MongoDB\String
     */
    protected $description;

    /**
     * @MongoDB\String
     */
    protected $services;

    /**
     * @MongoDB\String
     */
    protected $contact;

    /**
     * @MongoDB\EmbedMany(targetDocument="Tag")
     */
    protected $tags = array();

    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get locale
     *
     * @return string $locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set created
     *
     * @param timestamp $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return timestamp $created
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param date $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return date $updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set services
     *
     * @param string $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * Get services
     *
     * @return string $services
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set contact
     *
     * @param string $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get contact
     *
     * @return string $contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Add tags
     *
     * @param MacauSE\Bundle\Organization\ProfileBundle\Document\Tag $tags
     */
    public function addTags(\MacauSE\Bundle\Organization\ProfileBundle\Document\Tag $tags)
    {
        $this->tags[] = $tags;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection $tags
     */
    public function getTags()
    {
        return $this->tags;
    }
}
