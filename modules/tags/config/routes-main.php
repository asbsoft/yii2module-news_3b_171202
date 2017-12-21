<?php
// route without prefix => controller/action without current (and parent) module(s) IDs
return [
//...
    '?' => 'main/index', //!! no '' - never routes from root (or use normalizer)
];
