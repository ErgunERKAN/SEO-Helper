<?php namespace Arcanedev\SeoHelper\Entities;

use Arcanedev\SeoHelper\Contracts\Entities\MetaCollectionInterface;
use Arcanedev\SeoHelper\Contracts\Entities\WebmastersInterface;
use Arcanedev\Support\Traits\Configurable;

/**
 * Class     Webmasters
 *
 * @package  Arcanedev\SeoHelper\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Webmasters implements WebmastersInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Configurable;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The supported webmasters.
     *
     * @var array
     */
    protected $supported = [
        'google'    => 'google-site-verification',
        'bing'      => 'msvalidate.01',
        'alexa'     => 'alexaVerifyID',
        'pinterest' => 'p:domain_verify',
        'yandex'    => 'yandex-verification'
    ];

    /**
     * The meta collection.
     *
     * @var MetaCollectionInterface
     */
    protected $metas;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create Webmasters instance.
     *
     * @param  array  $configs
     */
    public function __construct(array $configs = [])
    {
        $this->setConfigs($configs);

        $this->metas = new MetaCollection;
        $this->init();
    }

    /**
     * Start the engine.
     */
    private function init()
    {
        foreach ($this->configs as $webmaster => $content) {
            $this->add($webmaster, $content);
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the webmaster meta name.
     *
     * @param  string  $webmaster
     *
     * @return string
     */
    private function getName($webmaster)
    {
        return $this->supported[$webmaster];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add a webmaster to collection.
     *
     * @param  string  $webmaster
     * @param  string  $content
     *
     * @return self
     */
    private function add($webmaster, $content)
    {
        if ($this->isSupported($webmaster)) {
            $this->metas->add($this->getName($webmaster), $content);
        }

        return $this;
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function render()
    {
        return $this->metas->render();
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }


    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if the webmaster is supported.
     *
     * @param  string  $webmaster
     *
     * @return bool
     */
    private function isSupported($webmaster)
    {
        return array_key_exists($webmaster, $this->supported);
    }
}
