<?php
return [
    ['GET', '/', ['PhpBlog\Controllers\IndexController', 'index']],
    ['GET', '/post/{name}', ['PhpBlog\Controllers\PostController', 'view']]
];