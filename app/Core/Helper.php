<?php

// Helper functions

function h($str) {
    return htmlentities($str, ENT_QUOTES, mb_internal_encoding());
}
