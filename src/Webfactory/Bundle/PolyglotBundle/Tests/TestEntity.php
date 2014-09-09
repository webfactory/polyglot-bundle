<?php

/*
 * (c) webfactory GmbH <info@webfactory.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webfactory\Bundle\PolyglotBundle\Tests;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Webfactory\Bundle\PolyglotBundle\Annotation as Polyglot;
use Webfactory\Bundle\PolyglotBundle\TranslatableInterface;

/**
 * Doctrine entity that is used for testing.
 *
 * @ORM\Entity()
 * @Polyglot\Locale(primary="en_GB")
 */
class TestEntity
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue
     */
    private $id = null;

    /**
     * A text in the master language. Can be set with a string and gets replaced with a TranslatableInterface by the
     * Doctrine PolyglotListener.
     *
     * @var TranslatableInterface|string|null
     * @ORM\Column(type="string", name="name")
     * @Polyglot\Translatable
     */
    public $name = null;

    /**
     * @ORM\OneToMany(targetEntity="TestEntityTranslation", mappedBy="entity")
     * @Polyglot\TranslationCollection
     */
    protected $_translations;

    public function __construct()
    {
        $this->_translations = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
}
