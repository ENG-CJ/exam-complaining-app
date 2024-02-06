<?php

class DatabaseConnection
{
    public static function db(): mysqli | bool
    {
        $conn = new mysqli('localhost', 'root', '', 'examComplainingDB');
        if ($conn->connect_error) return false;
        return $conn;
    }
}
