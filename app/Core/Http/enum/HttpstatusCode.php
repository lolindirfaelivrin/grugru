<?php

namespace Core\Http\enum;

enum HttpstatusCode: int
{
    case OK = 200;
    case Creato = 201;
    case Vietato = 403;
    case NonTrovato = 404;
    case ErroreInterno = 500;

}