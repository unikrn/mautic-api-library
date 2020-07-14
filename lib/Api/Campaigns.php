<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic, NP. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     MIT http://opensource.org/licenses/MIT
 */

namespace Mautic\Api;

/**
 * Campaigns Context
 */
class Campaigns extends Api
{

    /**
     * {@inheritdoc}
     */
    protected $endpoint = 'campaigns';

    /**
     * {@inheritdoc}
     */
    protected $listName = 'campaigns';

    /**
     * {@inheritdoc}
     */
    protected $itemName = 'campaign';

    /**
     * @var array
     */
    protected $bcRegexEndpoints = array(
        'campaigns/(.*?)/contact/(.*?)/add'    => 'campaigns/$1/contact/add/$2', // 2.6.0
        'campaigns/(.*?)/contact/(.*?)/remove' => 'campaigns/$1/contact/remove/$2' // 2.6.0
    );

    /**
     * {@inheritdoc}
     */
    protected $searchCommands = array(
        'ids',
        'is:published',
        'is:unpublished',
        'is:mine',
        'is:uncategorized',
        'category',
    );

    /**
     * Add a lead to the campaign
     *
     * @deprecated 2.0.1, use addContact instead
     *
     * @param int $id     Campaign ID
     * @param int $leadId Lead ID
     * @param int $timeout
     *
     * @return array|mixed
     */
    public function addLead($id, $leadId, $timeout = null)
    {
        return $this->addContact($id, $leadId, $timeout);
    }

    /**
     * Add a contact to the campaign
     *
     * @param int $id        Campaign ID
     * @param int $contactId Contact ID
     * @param int $timeout
     *
     * @return array|mixed
     */
    public function addContact($id, $contactId, $timeout = null)
    {
        return $this->makeRequest($this->endpoint.'/'.$id.'/contact/'.$contactId.'/add', array(), 'POST', $timeout);
    }

    /**
     * Remove a lead from the campaign
     *
     * @deprecated 2.0.1, use removeContact instead
     *
     * @param int $id     Campaign ID
     * @param int $leadId Lead ID
     * @param int $timeout
     *
     * @return array|mixed
     */
    public function removeLead($id, $leadId, $timeout = null)
    {
        return $this->removeContact($id, $leadId, $timeout);
    }

    /**
     * Remove a contact from the campaign
     *
     * @param int $id        Campaign ID
     * @param int $contactId Contact ID
     * @param int $timeout
     *
     * @return array|mixed
     */
    public function removeContact($id, $contactId, $timeout = null)
    {
        return $this->makeRequest($this->endpoint.'/'.$id.'/contact/'.$contactId.'/remove', array(), 'POST', $timeout);
    }

    /**
     * Get a list of stat items
     *
     * @param int    $id Campaign ID
     * @param int    $start
     * @param int    $limit
     * @param array  $order
     * @param array  $where
     * @param int $timeout
     *
     * @return array|mixed
     */
    public function getContacts($id, $start = 0, $limit = 0, array $order = array(), array $where = array(), $timeout = null)
    {
        $parameters = array();
        $args = array('start', 'limit', 'order', 'where');

        foreach ($args as $arg) {
            if (!empty($$arg)) {
                $parameters[$arg] = $$arg;
            }
        }

        return $this->makeRequest($this->endpoint.'/'.$id.'/contacts', $parameters, $timeout);
    }
    
    /**
     * Clone an Existing campaign
     *
     * @param int $id        Campaign ID
     * @param int $timeout
     *
     * @return array|mixed
     */
    public function cloneCampaign($id, $timeout = null)
    {
        return $this->makeRequest($this->endpoint.'/clone/'.$id, array(), 'POST', $timeout);
    }
}
