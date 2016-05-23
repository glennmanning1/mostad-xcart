<?php

namespace XLite\Module\Mostad\Contact\View\FormField\Select;

class FirmType extends \XLite\View\FormField\Select\Regular
{

    /**
     * getDefaultOptions
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [
                ''      => '',
                'CPA'   => 'CPA',
                'PA'    => 'PA',
                'EA'    => 'EA',
                'CFP'   => 'CFP',
                'Other' => 'Other',
        ];

    }
}
