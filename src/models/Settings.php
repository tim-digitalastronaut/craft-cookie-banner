<?php

namespace diginaut\cookiebanner\models;

use Craft;
use craft\base\Model;

/**
 * craft-cookie-banner settings
 */
class Settings extends Model
{

    public $colorBlack = "#141C26";
    public $colorWhite = "#FFFFFF";
    public $colorPrimary = "#1F8EF5";
    public $colorPrimaryHover = "#0CBFF0";
    public $colorTextTiny = "#CFDFED";
    public $colorCheckbox = "#52596A";
    public $colorSuccess = "#2ECE8A";

    public $bannerTitle = "Deze website maakt gebruik van cookies";
    public $bannerText = "Deze website gebruikt cookies voor jou te voorzien van de meest optimale gebruikservaring. Meer weten? Lees het cookiebeleid via de 'Meer info' knop of bepaal onderstaand je eigen voorkeuren.";

    public $policyUrl = "";
    
}
