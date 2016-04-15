<?php namespace AlistairShaw\Vendirun\App\Lib\Social;

class SocialLink {

    /**
     * @var string
     */
    protected $provider;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var int
     */
    protected $shareCount;

    public function __construct($provider, $link, $shareCount)
    {
        $this->provider = $provider;
        $this->link = $link;
        $this->shareCount = $shareCount;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return int
     */
    public function getShareCount()
    {
        return $this->shareCount;
    }

}