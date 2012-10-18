<?php

class Aurmil_ForceStoreCode_Model_Observer
{
    public function forceStoreCode($observer)
    {
        /* @var $front Mage_Core_Controller_Varien_Front */
        $front = $observer->getFront();
        $request = $front->getRequest();

        // for root only because internal links automatically add store code if needed
        if (Mage::getStoreConfigFlag(Mage_Core_Model_Store::XML_PATH_STORE_IN_URL)
            && Mage::getStoreConfigFlag('web/url/force_store')
            && !class_exists('Maged_Controller', false)
            && ('/' == $request->getOriginalPathInfo()))
        {
            $requestUri = $request->getRequestUri();
            if (false !== strpos($requestUri, '?'))
            {
                $requestUri = substr($requestUri, 0, strpos($requestUri, '?'));
            }

            $store = Mage::app()->getStore();

            // if different, means store code is not in URI
            if ($request->getBaseUrl() . '/' . $store->getCode() . '/' != $requestUri)
            {
                $url = $store->getWebsite()->getDefaultStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, $store->isCurrentlySecure());

                $response = $front->getResponse();
                $response->setRedirect($url, 301);
                $response->sendHeaders();
                exit;
            }
        }
    }
}
