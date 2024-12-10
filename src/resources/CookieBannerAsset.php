<?php

namespace diginaut\cookiebanner\resources;

use craft\web\AssetBundle;
use craft\web\assets\sites\SitesAsset;
use craft\web\assets\cp\CpAsset;

class CookieBannerAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = "@diginaut/cookiebanner/resources/dist";

        // $this->depends = [
        //     SitesAsset::class
        // ];

        $this->css = [
            'css/craft-cookie-banner.css',
        ];

        $this->js = [
            'js/craft-cookie-banner.js',
        ];

        parent::init();
    }
}
