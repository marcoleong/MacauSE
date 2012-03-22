<?php
namespace MacauSE\DirectoryBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;


/**
 * @MongoDB\Document
 */
class Profile implements Translatable
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
	 * @Gedmo\Translatable
     * @Assert\NotBlank
     * @MongoDB\String
     */
    protected $name;

    /**
     * @Gedmo\Slug(separator="-", updatable=false, fields={"name"})
     * @MongoDB\String
     */
    protected $slug;

    /**
     * @MongoDB\String
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
	 * @Gedmo\Translatable
     * @MongoDB\String
     */
    protected $description;

    /**
	 * @Gedmo\Translatable
     * @MongoDB\String
     */
    protected $services;

    /**
	 * @Gedmo\Translatable
     * @MongoDB\String
     */
    protected $contacts;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Tag",simple="true",cascade={"persist"})
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
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     * Set contacts
     *
     * @param string $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Get contacts
     *
     * @return string $contacts
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add tags
     *
     * @param MacauSE\DirectoryBundle\Document\Tag $tags
     */
    public function addTags(\MacauSE\DirectoryBundle\Document\Tag $tags)
    {
        $this->tags[] = $tags;
    }

	public function removeAllTags(){
		$this->tags = new \Doctrine\Common\Collections\ArrayCollection();
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

	public function setTranslatableLocale($locale)
   {
        $this->locale = $locale;
    }
}
