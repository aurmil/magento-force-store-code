<?php

/**
 * @author     Aurélien Millet
 * @link       https://github.com/aurmil/
 */

class Aurmil_ForceStoreCode_Model_Observer
{
    public function forceStoreCode($observer)
    {
        /* @var $front Mage_Core_Controller_Varien_Front */
        $front = $observer->getFront();
        $request = $front->getRequest();
        $store = Mage::app()->getStore();

        // for root only because internal links automatically include store code if needed
        if (('/' == $request->getOriginalPathInfo())
            && Mage::getStoreConfigFlag(Mage_Core_Model_Store::XML_PATH_STORE_IN_URL)
            && Mage::getStoreConfigFlag('web/url/force_store')
            && !$store->isAdmin()
            && !class_exists('Maged_Controller', false)
        ) {
            $requestUri = $request->getRequestUri();
            if (false !== strpos($requestUri, '?')) {
                $requestUri = substr($requestUri, 0, strpos($requestUri, '?'));
            }

            $expectedUri = $request->getBaseUrl().'/'.$store->getCode().'/';

            // if different, means store code is not in URI
            if ($expectedUri != $requestUri) {
                $url = $store->getWebsite()->getDefaultStore()->getBaseUrl(
                    Mage_Core_Model_Store::URL_TYPE_LINK,
                    $store->isCurrentlySecure()
                );

                // add GET params
                $query = $request->getQuery();
                if (!empty($query)) {
                    $requestUri = $request->getRequestUri();
                    $url .= substr($requestUri, strpos($requestUri, '?'));
                }

                $response = $front->getResponse();
                $response->setRedirect($url, 301);
                $response->sendHeaders();
                exit;
            }
        }
    }
}
