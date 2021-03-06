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
	"select" => 'Extra text in this field will be lost! Press submit again to continue.',
	"url" => ":Attribute must look like a URL.",
	"create" => "You have not selected a :attribute. Continuing may limit how often you can create a :attribute if a new one is created!",
	"discussion" => "This tag already exists in a discussion on this post. Choose another.",
	"attributes" => [
        'password_confirmation' => "the second password",
        'login' => "username or email"
    ],
];
