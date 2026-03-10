<?php

namespace SmartDato\FedEx\Enums;

enum LabelFormatType: string
{
    case COMMON2D = 'COMMON2D';
    case LABEL_DATA_ONLY = 'LABEL_DATA_ONLY';
}
