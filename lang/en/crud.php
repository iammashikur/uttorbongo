<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'products' => [
        'name' => 'Products',
        'index_title' => 'Products List',
        'new_title' => 'New Product',
        'create_title' => 'Create Product',
        'edit_title' => 'Edit Product',
        'show_title' => 'Show Product',
        'inputs' => [
            'name' => 'Name',
            'product_category_id' => 'Product Category',
            'brand_id' => 'Brand',
            'image' => 'Image',
            'product_type' => 'Product Type',
            'supplier_id' => 'Supplier',
            'seller_id' => 'Seller',
            'purchase_price' => 'Purchase Price',
            'price' => 'Price',
            'details' => 'Details',
            'show_on_website' => 'Show On Website',
        ],
    ],

    'product_categories' => [
        'name' => 'Product Categories',
        'index_title' => 'ProductCategories List',
        'new_title' => 'New Product category',
        'create_title' => 'Create ProductCategory',
        'edit_title' => 'Edit ProductCategory',
        'show_title' => 'Show ProductCategory',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'sellers' => [
        'name' => 'Sellers',
        'index_title' => 'Sellers List',
        'new_title' => 'New Seller',
        'create_title' => 'Create Seller',
        'edit_title' => 'Edit Seller',
        'show_title' => 'Show Seller',
        'inputs' => [
            'name' => 'Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'image' => 'Image',
            'document' => 'Document',
        ],
    ],

    'suppliers' => [
        'name' => 'Suppliers',
        'index_title' => 'Suppliers List',
        'new_title' => 'New Supplier',
        'create_title' => 'Create Supplier',
        'edit_title' => 'Edit Supplier',
        'show_title' => 'Show Supplier',
        'inputs' => [
            'name' => 'Name',
            'phone' => 'Phone',
            'address' => 'Address',
        ],
    ],

    'supplier_returns' => [
        'name' => 'Supplier Returns',
        'index_title' => 'SupplierReturns List',
        'new_title' => 'New Supplier return',
        'create_title' => 'Create SupplierReturn',
        'edit_title' => 'Edit SupplierReturn',
        'show_title' => 'Show SupplierReturn',
        'inputs' => [
            'supplier_id' => 'Supplier',
            'product_id' => 'Product',
        ],
    ],

    'shops' => [
        'name' => 'Shops',
        'index_title' => 'Shops List',
        'new_title' => 'New Shop',
        'create_title' => 'Create Shop',
        'edit_title' => 'Edit Shop',
        'show_title' => 'Show Shop',
        'inputs' => [
            'name' => 'Name',
            'address' => 'Address',
            'branch_id' => 'Branch',
        ],
    ],

    'branches' => [
        'name' => 'Branches',
        'index_title' => 'Branches List',
        'new_title' => 'New Branch',
        'create_title' => 'Create Branch',
        'edit_title' => 'Edit Branch',
        'show_title' => 'Show Branch',
        'inputs' => [
            'name' => 'Name',
            'address' => 'Address',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'shop_id' => 'Shop',
            'photo' => 'Photo',
        ],
    ],

    'sales' => [
        'name' => 'Sales',
        'index_title' => 'Sales List',
        'new_title' => 'New Sale',
        'create_title' => 'Create Sale',
        'edit_title' => 'Edit Sale',
        'show_title' => 'Show Sale',
        'inputs' => [
            'product_id' => 'Product',
            'product_code_id' => 'Product Code',
            'buyer_id' => 'Buyer',
            'purchase_price' => 'Purchase Price',
            'sale_price' => 'Sale Price',
            'user_id' => 'User',
            'shop_id' => 'Shop',
        ],
    ],

    'brands' => [
        'name' => 'Brands',
        'index_title' => 'Brands List',
        'new_title' => 'New Brand',
        'create_title' => 'Create Brand',
        'edit_title' => 'Edit Brand',
        'show_title' => 'Show Brand',
        'inputs' => [
            'name' => 'Name',
            'logo' => 'Logo',
        ],
    ],

    'buyers' => [
        'name' => 'Buyers',
        'index_title' => 'Buyers List',
        'new_title' => 'New Buyer',
        'create_title' => 'Create Buyer',
        'edit_title' => 'Edit Buyer',
        'show_title' => 'Show Buyer',
        'inputs' => [
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'document' => 'Document',
        ],
    ],

    'dues' => [
        'name' => 'Dues',
        'index_title' => 'Dues List',
        'new_title' => 'New Due',
        'create_title' => 'Create Due',
        'edit_title' => 'Edit Due',
        'show_title' => 'Show Due',
        'inputs' => [
            'buyer_id' => 'Buyer',
            'product_id' => 'Product',
            'product_code_id' => 'Product Code',
            'due_amount' => 'Due Amount',
            'user_id' => 'User',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
