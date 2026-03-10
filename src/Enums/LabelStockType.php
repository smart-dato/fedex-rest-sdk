<?php

namespace SmartDato\FedEx\Enums;

enum LabelStockType: string
{
    case PAPER_4X6 = 'PAPER_4X6';
    case STOCK_4X675 = 'STOCK_4X675';
    case PAPER_4X675 = 'PAPER_4X675';
    case PAPER_4X8 = 'PAPER_4X8';
    case PAPER_4X9 = 'PAPER_4X9';
    case PAPER_7X475 = 'PAPER_7X475';
}
