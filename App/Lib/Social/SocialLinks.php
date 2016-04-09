<?php namespace AlistairShaw\Vendirun\App\Lib\Social;

interface SocialLinks {

    public function getLinks($pageUrl, $pageTitle, $pageText, $pageImage);

}