<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$rules = [
    'Item_Category' => [
        'label' => 'Item Category', // The label for the field, used in error messages
        'rules' => 'required|is_unique[category.Item_Category]' // The validation rules
    ],
];

// Sample 1: Applying Required and Valid Email Rules
$rules = [
    'email' => 'required|valid_email',
];

// Sample 2: Applying Alpha and Max Length Rules
$rules = [
    'first_name' => 'alpha|max_length[50]',
];

// Sample 3: Applying Alpha Numeric and Min Length Rules
$rules = [
    'username' => 'alpha_numeric|min_length[6]',
];

// Sample 4: Applying Numeric, Min Length, and Max Length Rules
$rules = [
    'age' => 'numeric|min_length[1]|max_length[3]',
];

// Sample 5: Applying Numeric and Exact Length Rules
$rules = [
    'phone_number' => 'numeric|exact_length[10]',
];

// Sample 6: Applying Unique, Alpha Numeric, and Min Length Rules
$rules = [
    'password' => 'is_unique[users.password]|alpha_numeric|min_length[8]',
];

// Sample 7: Applying Alpha, Regex, and Max Length Rules
$rules = [
    'title' => 'alpha|regex_match[/^[a-zA-Z\s]+$/]|max_length[100]',
];

// Sample 8: Applying In List, Valid URL, and Matches Rules
$rules = [
    'website' => 'in_list[http://example.com,https://example.com]|valid_url|matches[confirm_website]',
];

// Sample 9: Applying Callback, Valid Email, and Required Rules
$rules = [
    'email' => 'callback_email_check|required|valid_email',
];
