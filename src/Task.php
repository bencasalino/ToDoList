<?php
    class Task
    {
        private $description;

        function __construct($description)
        {
            $this->description = $description;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        /* Save Task in $_SESSION variable */

        function save()
        {
            array_push($_SESSION['list_of_tasks'], $this);
        }

        /* return the list of all of our tasks    */
        static function getAll()
        {
            return $_SESSION['list_of_tasks'];
        }

        // reset to blank array when delete
        static function deleteAll()
        {
            $_SESSION['list_of_tasks'] = array();
        }
    }
 ?>
