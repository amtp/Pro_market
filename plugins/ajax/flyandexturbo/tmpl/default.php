<?php

/**
 * @package   FL Yandex Turbo Plugin
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
 error_reporting(0);
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Social

$socialHtml     = $callbackHtml = $formHtml = $advert_place_1 = $advert_place_2 = '';
$moduleTop      = $this->renderModule('fl-yandex-turbo-top');
$moduleBottom   = $this->renderModule('fl-yandex-turbo-bottom');

if ((int) $this->params->get('items_social')) {
	$socialOptions = $this->params->get('items_social_options');

	if (!empty($socialOptions)) {
		$socialHtml = '<div data-block="share" data-network="'.implode(', ', $socialOptions).'"></div> ';
	}
}

// Callback

if ((int) $this->params->get('items_callback')) {
    $callbackTitle      = $this->params->get('items_callback_title');
    $callbackStick      = $this->params->get('items_callback_stick');
    $callbackOptions    = $this->params->get('items_callback_options');

    if (!empty($callbackOptions)) {
        $callbackHtml .= '<div data-block="widget-feedback" data-title="'.$callbackTitle.'" data-stick="'.$callbackStick.'">';

        foreach ($callbackOptions as $key => $callback) {
            $callbackHtml .= '<div data-type="'.$callback->items_callback_type.'"'.
                        ($callback->items_callback_url ? ' data-url="'.$callback->items_callback_url.'"' : '').
                        ($callback->items_callback_email ? ' data-send-to="'.$callback->items_callback_email.'"' : '').
                        ($callback->items_callback_company ? ' data-agreement-company="'.$callback->items_callback_company.'"' : '').
                        ($callback->items_callback_link ? ' data-agreement-link="'.$callback->items_callback_link.'"' : '').
                        '></div>';
        }

        $callbackHtml .= '</div>';
    }
}

// Form

if ((int) $this->params->get('items_form')) {
    $formType       = $this->params->get('items_form_type');
    $formEmail      = $this->params->get('items_form_email');
    $formCompany    = $this->params->get('items_form_company');
    $formLink       = $this->params->get('items_form_link');
    $formBgcolor    = $this->params->get('items_form_bgcolor');
    $formColor      = $this->params->get('items_form_color');
    $formBold       = $this->params->get('items_form_bold');
    $formText       = $this->params->get('items_form_text');

    if ($formType == 'item') {
        $formHtml .= '<form data-type="callback" data-send-to="'.$formEmail.'">'
                    .($formLink ? ' data-agreement-link="'.$formLink.'"' : '')
                    .($formCompany ? 'data-agreement-company="'.$formCompany.'"' : '')
                    .'></form>';
    } else {
        $formHtml .= '<button formaction="mailto:'.$formEmail.'" data-send-to="'.$formEmail.'"'.
                    ($formLink ? ' data-agreement-link="'.$formLink.'"' : '').
                    ($formCompany ? ' data-agreement-company="'.$formCompany.'"' : '').
                    ($formBgcolor ? ' data-background="'.$formBgcolor.'"' : '').
                    ($formColor ? ' data-color="'.$formColor.'"' : '').
                    ($formBold ? ' data-primary="'.$formBold.'"' : '').
                    '>'.$formText.'</button>';
    }
}

?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL; ?>
<rss
    xmlns:yandex="http://news.yandex.ru"
    xmlns:media="http://search.yahoo.com/mrss/"
    xmlns:turbo="http://turbo.yandex.ru"
    version="2.0">

    <?php if (!empty($items)) : ?>

        <channel>
        	<turbo:cms_plugin>8D723BD54DAF289363945EFC48B90F4C</turbo:cms_plugin>
            <title><?php echo $this->params->get('channel_title'); ?></title>
            <link><?php echo JURI::root(); ?></link>
            <description><?php echo $this->params->get('channel_description'); ?></description>
            <language><?php echo $this->params->get('channel_language'); ?></language>

            <?php if ((int) $this->params->get('items_analitics')) {
            	$analiticsOptions = $this->params->get('items_analitics_options');

            	if (!empty($analiticsOptions)) {
            		foreach ($analiticsOptions as $analitic) { ?>
            			<yandex:analytics id="<?php echo $analitic->items_analitics_id; ?>" type="<?php echo $analitic->items_analitics_type; ?>" <?php echo $analitic->items_analitics_liveinternet_params ? 'params="'.$analitic->items_analitics_liveinternet_params.'"' : ''; ?>></yandex:analytics>
            		<?php }
            	}
            } ?>

            <?php if ((int) $this->params->get('items_advertisement')) {
            	$advertisementOptions = $this->params->get('items_advertisement_options');

            	if (!empty($advertisementOptions)) {
            		$i = 1;
            		foreach ($advertisementOptions as $advertisement) { 
            			${'advert_place_'.$i} = '<figure data_turbo_ad_id="flyandexturbo_ads_'.$i.'"></figure>';
            		?>
            			<yandex:adNetwork type="<?php echo $advertisement->items_advertisement_type; ?>" <?php echo $advertisement->items_advertisement_id ? 'id="'.$advertisement->items_advertisement_id.'"' : ''; ?> turbo-ad-id="flyandexturbo_ads_<?php echo $i;?>"><?php echo $advertisement->items_advertisement_attr ? '<![CDATA['.$advertisement->items_advertisement_attr.']]>' : '';?></yandex:adNetwork>
            		<?php $i++; }
            	}
            } ?>

    		<?php foreach ($items as $key => $item) : ?>
                <?php 
                    if (strpos($item['content'], '{flyandexturbo_no_form}') !== false) { // Remove Form For Current Item
                        $item['content'] = str_replace('{flyandexturbo_no_form}', '', $item['content']);
                        $pageFormHtml = '';
                    } else {
                        $pageFormHtml = $formHtml;
                    }
                ?>
    	        <item turbo="true">
    	           	<title><?php echo $item['title']; ?></title>
    	           	<turbo:topic><?php echo $item['title']; ?></turbo:topic>
    	           	<link><?php echo htmlspecialchars($item['link']); ?></link>
    	           	<guid isPermaLink="false"><?php echo htmlspecialchars($item['link']); ?></guid>
    	           	<pubDate><?php echo $item['date']; ?></pubDate>
    	           	<author><?php echo $item['author']; ?></author>
    	            <turbo:content><?php echo '<![CDATA['.
                        '<header>'.($item['image'] ? $item['image'] : '').'<h1>'.$item['title'].'</h1></header>'.
                        $moduleTop.                                         // Module Position Top
                        $advert_place_1.                                    // Ads Place #1
                        $item['content'].                                   // Content
                        $callbackHtml.                                      // Callback Buttons
                        $pageFormHtml.                                      // Callback Form
                        $socialHtml.                                        // Social Buttons
                        $advert_place_2.                                    // Ads Place #2
                        $moduleBottom.                                      // Module Position Bottom
                        ']]>'; ?></turbo:content>

    	            <?php if ($item['related']) : ?>
    	            	<yandex:related>
    		            	<?php foreach ($item['related'] as $key => $related) : ?>
    		            		<link url="<?php echo $related['link']; ?>" <?php echo $related['image'] ? 'img="'.$related['image'].'"' : ''; ?>><?php echo $related['text']; ?></link>
    		            	<?php endforeach; ?>
    		            </yandex:related>
    	            <?php endif;?>

    	        </item>
    		<?php endforeach; ?>

    	</channel>

    <?php else : ?>
        <noitems><?php echo JText::_('PLG_FLYANDEXTURBO_NO_ITEMS');?></noitems>
    <?php endif; ?>
</rss>