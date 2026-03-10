<?php

namespace SmartDato\FedEx\Enums;

enum WorkflowName: string
{
    case ETDPreshipment = 'ETDPreshipment';
    case ETDPostshipment = 'ETDPostshipment';
}
