<?php

use Lavender\Support\Facades\Attribute;
use Lavender\Support\Facades\Relationship;

return [


    /**
     * Theme model
     * Used to describe themes, locales.
     */
    'theme' => [
        'class' =>  'Lavender\Theme\Database\Theme',
        'attributes' => [
            'code' => [
                'label' => 'Code',
                'type' => Attribute::VARCHAR,
                'unique' => true,
                'backend.table' => true,
                'backend.renderer' => 'Lavender\Backend\Handlers\Entity\EditLink',
            ],
            'name' => [
                'label' => 'Name',
                'type' => Attribute::VARCHAR,
                'backend.table' => true,
                'backend.renderer' => 'Lavender\Backend\Handlers\Entity\EditLink',
            ],
        ],
        'relationships' => [
            'parent' => [
                'entity' => 'theme',
                'type' => Relationship::HAS_ONE,
            ],
        ],
    ],


];