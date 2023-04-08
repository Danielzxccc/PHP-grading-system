<?php
function identifyRemark($string)
{
    switch ($string) {
        case 'INC':
            return "INCOMPLETE";
            break;
        case 'NC':
            return "NO CREDIT";
            break;
        case 'UD':
            return "UNOFFICIALLY DROPPED";
            break;
        case 'OD':
            return "OFFICIALLY DROPPED";
            break;
        default:
            return "NONE";
            break;
    }
}
