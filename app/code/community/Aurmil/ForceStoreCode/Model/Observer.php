<?php
/**
 * @author Aurélien Millet
 * @link https://github.com/aurmil/magento-force-store-code
 * @license https://github.com/aurmil/magento-force-store-code/blob/master/LICENSE.md
 */

class Aurmil_ForceStoreCode_Model_Observer
{
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
        if ('/' === $request->getOriginalPathInfo()
            && $store->getStoreInUrl()
            && Mage::helper('aurmil_forcestorecode')->isEnabled()
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

                // add GET params
                $url .= $query;

                $front->getResponse()
                    ->setRedirect($url, 301)
                    ->sendHeadersAndExit();
            }
        }

        return $this;
    }
}
