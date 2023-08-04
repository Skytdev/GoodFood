<?php

class FakerArticle
{
    public static $ingredientList = [
        [
            'name' => 'Tomate',
            'unit' => 'kg',
        ],
        [
            'name' => 'Salade',
            'unit' => 'kg',
        ],
        [
            'name' => 'Steak',
            'unit' => 'unité',
        ],
        [
            'name' => 'Pain',
            'unit' => 'unité',
        ],
        [
            'name' => 'Riz',
            'unit' => 'kg',
        ],
        [
            'name' => 'Fromage',
            'unit' => 'kg',
        ],
        [
            'name' => 'Poulet',
            'unit' => 'kg',
        ],
        [
            'name' => 'Pates a pizza',
            'unit' => 'kg',
        ],
        [
            'name' => 'Cheddar pizza',
            'unit' => 'kg',
        ],
        [
            'name' => 'Tranche de cheddar',
            'unit' => 'unité',
        ],
        [
            'name' => 'Champignon de paris',
            'unit' => 'kg',
        ],
        [
            'name' => 'Sauce tomate',
            'unit' => 'litre',
        ],
        [
            'name' => 'Crêpe',
            'unit' => 'unité',
        ],
        [
            'name' => 'Cordon bleu',
            'unit' => 'unité',
        ],
        [
            'name' => 'Pâtes',
            'unit' => 'kg',
        ],
        [
            'name' => 'Lardons',
            'unit' => 'kg',
        ],
        [
            'name' => 'Crème fraîche',
            'unit' => 'kg',
        ],
        [
            'name' => 'Cordon bleu',
            'unit' => 'unité',
        ],
        [
            'name' => 'Coca Cola',
            'unit' => 'unité',
        ],
    ];

    public static $productCategoryNameList = [
        'Pizza',
        'Burger',
        'Tacos',
        'Japonais',
        'Vegan',
        'Halal',
        'Italien',
        'Fast food',
        'Américain',
        'Boisson',
    ];

    public static $productList = [
        [
            'name' => 'Pizza 4 fromages',
            'productCategory' => 'Pizza',
            'ingredientProduct' => [
                'Tomate',
                'Poulet',
                'Pates a pizza',
                'Sauce tomate',
            ],
        ],
        [
            'name' => 'Calzone',
            'productCategory' => 'Pizza',
            'ingredientProduct' => [
                'Sauce tomate',
                'Poulet',
                'Pates a pizza',
            ],
        ],
        [
            'name' => 'Cheese burger',
            'productCategory' => 'Burger',
            'ingredientProduct' => [
                'Tomate',
                'Pain',
                'Steak',
                'Pain',
                'Tranche de cheddar',
            ],
        ],
        [
            'name' => 'Double cheese burger',
            'productCategory' => 'Burger',
            'ingredientProduct' => [
                'Tomate',
                'Pain',
                'Steak',
                'Pain',
                'Tranche de cheddar',
            ],
        ],
        [
            'name' => 'California roll',
            'productCategory' => 'Japonais',
            'ingredientProduct' => [
                'Riz',
            ],
        ],
        [
            'name' => 'Maki',
            'productCategory' => 'Japonais',
            'ingredientProduct' => [
                'Riz',
            ],
        ],
        [
            'name' => 'Tacos M',
            'productCategory' => 'Tacos',
            'ingredientProduct' => [
                'Crêpe',
                'Poulet',
            ],
        ],
        [
            'name' => 'Tacos XL',
            'productCategory' => 'Tacos',
            'ingredientProduct' => [
                'Crêpe',
                'Cordon bleu',
            ],
        ],
        [
            'name' => 'BigMac',
            'productCategory' => 'Fast food',
            'ingredientProduct' => [
                'Tomate',
                'Pain',
                'Steak',
                'Pain',
                'Fromage',
            ],
        ],
        [
            'name' => 'Pâtes à la carbonara',
            'productCategory' => 'Italien',
            'ingredientProduct' => [
                'Pâtes',
                'Lardons',
                'Crème fraîche',
                'Fromage',
            ],
        ],
        [
            'name' => 'Coca Cola',
            'productCategory' => 'Boisson',
            'ingredientProduct' => [
                'Coca Cola',
            ],
        ],
    ];

    public static $menuList = [
        [
            'name' => 'menu duo',
            'productMenu' => [
                'Coca Cola',
            ],
        ],
    ];
}