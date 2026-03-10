<?php

namespace SmartDato\FedEx\Enums;

enum ImageType: string
{
    case ZPLII = 'ZPLII';
    case EPL2 = 'EPL2';
    case PDF = 'PDF';
    case PNG = 'PNG';
}
