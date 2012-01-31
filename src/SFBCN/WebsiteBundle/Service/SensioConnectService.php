<?php

namespace SFBCN\WebsiteBundle\Service;

class SensioConnectService
{
    protected $groupName;

    /**
     * Sets configured RSS Feeds (@see services.yml)
     * @param string $name
     */
    public function setGroupName($name)
    {
        $this->groupName = $name;
    }

    /**
     * Gets injected RSS Feeds
     * @return array
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Gets Symfony-Barcelona info from Sensio Connect. Info is stored in APC during an hour to increase speed
     * @return array
     */
    public function getGroupInfo()
    {
        $apcKey = 'sfbcn_sensioconnect';
        if (extension_loaded('apc') && apc_exists($apcKey)) {
            $sfConnect = apc_fetch($apcKey);
        } else {
            $sfConnect = json_decode(file_get_contents('https://connect.sensiolabs.com/club/' . $this->getGroupName() . '.json'), true);
            apc_store($apcKey, $sfConnect, 3600);
        }

        return $sfConnect;
    }
}