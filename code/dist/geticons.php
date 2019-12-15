<?php

$icons = array_merge(
    glob('assets/icons/solid/*.svg'),
    glob('assets/icons/regular/*.svg'),
    glob('assets/icons/brands/*.svg')
);

echo json_encode( array("hits" => $icons ));
