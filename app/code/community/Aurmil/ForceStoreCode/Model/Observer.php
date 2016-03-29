<?php
/**
 * @author Aurélien Millet
 * @link https://github.com/aurmil/magento-force-store-code
 * @license https://github.com/aurmil/magento-force-store-code/blob/master/LICENSE.md
 */

class Aurmil_ForceStoreCode_Model_Observer
{
    const XML_PATH_FORCE_STORE_IN_URL = 'web/url/force_store';

    /**
     * Event "controller_front_init_before"
     *
     * @event controller_front_init_before
     * @param Varien_Event_Observer $observer
     * @return Aurmil_ForceStoreCode_Model_Observer
     */
    public function forceStoreCode($observer)
    {
        /* @var $front Mage_Core_Controller_Varien_Front */
        $front = $observer->getEvent()->getFront();
        $request = $front->getRequest();
        $store = Mage::app()->getStore();

        // for root only because internal links automatically include store code if needed
        if (('/' == $request->getOriginalPathInfo())
            && Mage::getStoreConfigFlag(Mage_Core_Model_Store::XML_PATH_STORE_IN_URL)
            && Mage::getStoreConfigFlag(self::XML_PATH_FORCE_STORE_IN_URL)
            && !$store->isAdmin()
            && !class_exists('Maged_Controller', false)
        ) {
            $requestUri = $request->getRequestUri();
            $query = '';

            if (false !== strpos($requestUri, '?')) {
                $requestUri = explode('?', $requestUri);
                $query = '?'.$requestUri[1];
                $requestUri = $requestUri[0];
            }

            $expectedUri = $request->getBaseUrl() . '/' . $store->getCode() . '/';

            // if different, means store code is not in URI
            if ($expectedUri != $requestUri) {
                $url = $store->getWebsite()->getDefaultStore()->getBaseUrl(
                    Mage_Core_Model_Store::URL_TYPE_LINK,
                    $store->isCurrentlySecure()
                );
                $url .= $query; // add GET params

                $front->getResponse()
                    ->setRedirect($url, 301)
                    ->sendHeaders(); // sendHeadersAndExit() appeared in 1.9
                exit;
            }
        }

        return $this;
    }
}
