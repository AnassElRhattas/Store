<?php

return [
    'font_dir' => storage_path('fonts/'),
    'font_cache' => storage_path('fonts/'),
    'temp_dir' => sys_get_temp_dir(),
    'chroot' => realpath(base_path()),
    'allowed_protocols' => [
        'file://' => ['rules' => []],
        'http://' => ['rules' => []],
        'https://' => ['rules' => []]
    ],
    'log_output_file' => null,
    'default_media_type' => 'screen',
    'default_paper_size' => 'a4',
    'default_paper_orientation' => 'portrait',
    'default_font' => 'Amiri',
    'dpi' => 96,
    'enable_php' => false,
    'enable_javascript' => true,
    'enable_remote' => true,
    'font_height_ratio' => 1.1,
    'enable_html5_parser' => true,
    'enable_font_subsetting' => true,
    'pdf_backend' => 'CPDF',
    'default_font_size' => '12',
    'auto_script_to_lang' => true,
    'is_html5_parser_enabled' => true,
    'is_remote_enabled' => true,
    'is_php_enabled' => false,
    'is_javascript_enabled' => true,
    'is_font_subsetting_enabled' => true,
    'unicode_enabled' => true
];