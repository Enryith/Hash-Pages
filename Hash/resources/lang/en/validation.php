<?php

return [
    "min.string" => ':Attribute must be more than :min characters.',
    "max.string" => ':Attribute must be less than :max characters.',
    "required" => ':Attribute field is required.',
    "same" => ':Attribute must match :other.',
    "alpha_num" => ':Attribute can only be letters and numbers.',
    "email" => 'The :attribute field does not look like an email.',
    "unique" => 'That :attribute is already used.',
	"image" => ':Attribute must be an image.',
	'dimensions' => ':Attribute must be less than :max_height x :max_width px',
	'exists' => ':Attribute does not exist.',
	"attributes" => [
        'password_confirmation' => "the second password",
        'login' => "username or email"
    ],
];
