<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="message")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * Message
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $id_sender;

    /**
     * @return int
     */
    public function getIdSender()
    {
        return $this->id_sender;
    }

    /**
     * @param int $id_sender
     */
    public function setIdSender($id_sender)
    {
        $this->id_sender = $id_sender;
    }

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $id_receiver;

    /**
     * @return int
     */
    public function getIdReceiver()
    {
        return $this->id_receiver;
    }

    /**
     * @param int $id_receiver
     */
    public function setIdReceiver($id_receiver)
    {
        $this->id_receiver = $id_receiver;
    }

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $content;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Message
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }
}
