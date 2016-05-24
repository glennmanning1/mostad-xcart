<?php

namespace XLite\Module\Mostad\Contact\View\FormField\Select;

class FoundWebsiteBy extends \XLite\View\FormField\Select\Regular
{

    /**
     * getDefaultOptions
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [
                ''                         => '--Please select one--',
                'Online search'            => 'Online search',
                'Journal of Accountancy'   => 'Journal of Accountancy',
                'Accounting Today'         => 'Accounting Today',
                'State Society Newsletter' => 'State Society Newsletter',
                'Mail piece you sent me'   => 'Mail piece you sent me',
                'Personal referral'        => 'Personal referral',
                'none of the above'        => 'none of the above',
        ];

    }
}
