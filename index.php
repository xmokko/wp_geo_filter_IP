<?php

function wp_geo_filter_IP() {

    // 30 days (3600 sec = 1 hour)
    $cookie_expire = time()+3600*24*30;

    // cookie check
    if ($_COOKIE["xTestCookie"] == 1) {
        setcookie("xTestCookie", 1, $cookie_expire, "/");
        return true;
    }


    // bots check
    $bot_all = array(
        'YandexBot', 'YandexAccessibilityBot', 'YandexMobileBot','YandexDirectDyn',
        'YandexScreenshotBot', 'YandexImages', 'YandexVideo', 'YandexVideoParser',
        'YandexMedia', 'YandexBlogs', 'YandexFavicons', 'YandexWebmaster',
        'YandexPagechecker', 'YandexImageResizer','YandexAdNet', 'YandexDirect',
        'YaDirectFetcher', 'YandexCalendar', 'YandexSitelinks', 'YandexMetrika',
        'YandexNews', 'YandexNewslinks', 'YandexCatalog', 'YandexAntivirus',
        'YandexMarket', 'YandexVertis', 'YandexForDomain', 'YandexSpravBot',
        'YandexSearchShop', 'YandexMedianaBot', 'YandexOntoDB', 'YandexOntoDBAPI',
        'Googlebot', 'Googlebot-Image', 'Mediapartners-Google', 'AdsBot-Google',
        'Mail.RU_Bot', 'bingbot', 'Accoona', 'ia_archiver', 'Ask Jeeves',
        'OmniExplorer_Bot', 'W3C_Validator', 'WebAlta', 'YahooFeedSeeker', 'Yahoo!',
        'Ezooms', '', 'Tourlentabot', 'MJ12bot', 'AhrefsBot', 'SearchBot', 'SiteStatus',
        'Nigma.ru', 'Baiduspider', 'Statsbot', 'SISTRIX', 'AcoonBot', 'findlinks',
        'proximic', 'OpenindexSpider','statdom.ru', 'Exabot', 'Spider', 'SeznamBot',
        'oBot', 'C-T bot', 'Updownerbot', 'Snoopy', 'heritrix', 'Yeti',
        'DomainVader', 'DCPbot', 'PaperLiBot'
    );

    foreach($bot_all as $row)
        if (stripos($_SERVER['HTTP_USER_AGENT'], $row) !== false) return true;


    // set cookie | filter region RU + google\yandex
    $ref = $_SERVER['HTTP_REFERER'];
    if(strstr($ref, "google.") || strstr($ref, "yandex")) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

        if ($ip_data->geoplugin_countryCode == 'RU') {
            setcookie("xTestCookie", 1, $cookie_expire, "/");
            return true;
        }
    }


    return false;
}


if ( !wp_geo_filter_IP() )
{
    header("HTTP/1.0 404 Not Found");
    exit("404 error");
}





/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
