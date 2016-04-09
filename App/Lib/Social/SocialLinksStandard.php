<?php namespace AlistairShaw\Vendirun\App\Lib\Social;

use Config;
use SocialLinks\Page;

class SocialLinksStandard implements SocialLinks {

    /**
     * @var array
     */
    private $availableProviders = ['facebook', 'twitter', 'plus', 'pinterest', 'linkedin', 'stumbleupon'];

    public function getLinks($pageUrl, $pageTitle, $pageText, $pageImage, $providers = [])
    {
        $page = new Page([
            'url' => $pageUrl,
            'title' => $pageTitle,
            'text' => $pageText,
            'image' => $pageImage,
            'twitterUser' => $this->twitterUser()
        ]);

        $final = [];
        foreach ($this->checkProviders($providers) as $provider)
        {
            $final[] = new SocialLink($provider, $page->{$provider}->shareUrl, $page->{$provider}->shareCount);
        }

        return $final;
    }

    /**
     * @return string
     */
    private function twitterUser()
    {
        $clientInfo = Config::get('clientInfo');
        return $clientInfo->social->twitter;
    }

    /**
     * @param array $providers
     * @return array
     */
    private function checkProviders($providers = [])
    {
        if (count($providers) == 0) return $this->availableProviders;

        $final = [];
        foreach ($providers as $provider)
        {
            if (in_array($provider, $this->availableProviders)) $final[] = $provider;
        }

        return $final;
    }
}