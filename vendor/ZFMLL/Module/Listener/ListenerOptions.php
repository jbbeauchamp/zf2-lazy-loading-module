<?php

namespace ZFMLL\Module\Listener;

use Zend\Module\Listener\ListenerOptions as BaseListener;

class ListenerOptions extends BaseListener
{
    /**
     * @var array
     */
    protected $lazyLoading = array();
    
    /**
     * Get array of module loadinf with condition
     *
     * @return bool
     */
    public function getLazyLoading()
    {
        return $this->lazyLoading;
    }

    /**
     * Set array of module loadinf with condition
     *
     * @param array $lazyLoading
     * @return ListenerOptions
     */
    public function setLazyLoading(array $lazyLoading)
    {
        $this->lazyLoading = $lazyLoading;
        return $this;
    }
}