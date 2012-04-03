<?php

namespace Repository;

class DumbRepository extends Repository
{
    public function getTableName()
    {
        return 'dumb';
    }
}